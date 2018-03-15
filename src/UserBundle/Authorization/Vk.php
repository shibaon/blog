<?php

namespace UserBundle\Authorization;

use UserBundle\Entity\User;

class Vk extends OAuthAbstract
{
	protected $token = array();

	public function getAuthorizationLink()
	{
		$params = array(
			'client_id' => $this->getSettingsService()->get('social.vk_appid'),
			'scope' => '',
			'redirect_uri' => $this->generateUrl('_vk_redirect', array(), true) . $this->getBackUrl(),
			'response_type' => 'code',
		);

		return 'https://oauth.vk.com/authorize?' . $this->getParamString($params);
	}

	protected function fillUserData(User $user)
	{
		$this->getToken();

		$user
			->setUrl('http://vk.com/id' . $this->token['user_id'])
			->setVkId($this->token['user_id']);
		$params = array(
			'uids' => $user->getVkId(),
			'fields' => 'nickname,first_name,last_name,photo_big',
			'access_token' => $this->token['access_token'],
		);

		$result = json_decode($this->curlExecute('https://api.vk.com/method/users.get?' . $this->getParamString($params)), true);
		if (!$result['response']) {
			throw new \Exception('Не получилось получить информацию о пользователе');
		}
		$result = $result['response'][0];
		$user
			->setName($result['first_name'] . ' ' . $result['last_name']);
		/*if (!$user->getAvatar() && $result['photo_big']) {
			$this->setUserAvatar($user, $result['photo_big']);
		}*/
	}

	/**
	 * @return User
	 */
	protected function findUser()
	{
		$this->getToken();

		return $this->getUserService()->getUserByVkId($this->token['user_id']);
	}

	protected function getToken()
	{
		if (!$this->token) {
			$data = $this->getRequest()->query->all();
			$code = @$data['code'];

			if (!$code) {
				throw new \Exception('Параметр code не получен');
			}

			$params = array(
				'client_id' => $this->getSettingsService()->get('social.vk_appid'),
				'client_secret' => $this->getSettingsService()->get('social.vk_secret'),
				'code' => $code,
				'redirect_uri' => $this->generateUrl('_vk_redirect', array(), true) . $this->getBackUrl(),
			);

			$token = json_decode($this->curlExecute('https://oauth.vk.com/access_token?' . $this->getParamString($params)), true);
			if (!@$token['access_token']) {
				throw new \Exception('Access token не получен: ' . print_r($token, true));
			}

			$this->token = $token;
		}

		return $this->token;
	}

}