<?php

namespace Kh\UserBundle\Authorization;

use Kh\UserBundle\Entity\User;

class Fb extends OAuthAbstract
{
	protected $data;

	public function getAuthorizationLink()
	{
		$params = array(
			'client_id' => $this->getSettingsManager()->get('social.fb_appid'),
			'redirect_uri' => $this->generateUrl('_fb_redirect', array(), true) . $this->getBackUrl(),
			'response_type' => 'code',
			'scope' => 'email',
		);

		return 'https://www.facebook.com/dialog/oauth?' . $this->getParamString($params);
	}

	protected function fillUserData(User $user)
	{
		$this->getData();

		$user
			->setUrl($this->data['link'])
			->setFbId($this->data['id'])
			->setName($this->data['first_name'] . ' ' . $this->data['last_name']);
		if ($this->data['email']) {
			$user
				->setEmail($this->data['email']);
		}
		/*if (!$user->getAvatar() && isset($this->data['picture']['data']['url'])) {
			$this->setUserAvatar($user, 'http://graph.facebook.com/' . $this->data['id'] . '/picture?type=large');
		}*/
	}

	/**
	 * @return User
	 */
	protected function findUser()
	{
		$this->getData();
		if (isset($this->data['email'])) {
			return $this->getUserManager()->getUserByEmail($this->data['email']);
		} else {
			return $this->getUserManager()->getUserByFbId($this->data['id']);
		}
	}

	protected function getData()
	{
		if (!$this->data) {
			$incoming = $this->getRequest()->query->all();
			if (!@$incoming['code']) {
				throw new \Exception('Fb exception: ' . print_r($incoming, true));
			}
			$params = array(
				'client_id' => $this->getSettingsManager()->get('social.fb_appid'),
				'redirect_uri' => $this->generateUrl('_fb_redirect', array(), true) . $this->getBackUrl(),
				'client_secret' => $this->getSettingsManager()->get('social.fb_secret'),
				'code' => $incoming['code'],
			);

			$tokenStr = $this->curlExecute('https://graph.facebook.com/oauth/access_token?' . $this->getParamString($params));
			$token = array();
			foreach (explode('&', $tokenStr) as $part) {
				$parts = explode('=', $part);
				$token[$parts[0]] = $parts[1];
			}
			if (!@$token['access_token']) {
				throw new \Exception('Access token не получен: ' . print_r($tokenStr, true));
			}
			$this->c->getSession();
			require_once('fb/facebook.php');
			$fb = new \Facebook(array(
				'appId' => $this->getSettingsManager()->get('social.fb_appid'),
				'secret' => $this->getSettingsManager()->get('social.fb_secret'),
			));
			$fb->setAccessToken($token['access_token']);
			$this->data = $fb->api('me', array(
				'fields' => 'id,first_name,last_name,email,picture,link'
			));

		}

		return $this->data;
	}

}