<?php

namespace UserBundle\Authorization;

use UserBundle\Entity\User;
use Svi\Application;

class Twitter extends OAuthAbstract
{
	protected $data = null;

	public function __construct(Application $app)
	{
		parent::__construct($app);

		require_once('twitteroauth/twitteroauth.php');
	}

	public function getAuthorizationLink()
	{
		if ($this->getSettingsService()->get('social.twitter_consumer_key') && $this->getSettingsService()->get('social.twitter_consumer_secret')) {
			$connection = new \TwitterOAuth(
				$this->getSettingsService()->get('social.twitter_consumer_key'), $this->getSettingsService()->get('social.twitter_consumer_secret'));
			$request_token = $connection->getRequestToken($this->generateUrl('_twitter_authorization_redirect', array(), true) . $this->getBackUrl());
			$this->getSessionService()->set('twitter_request_token', $request_token);

			return $connection->getAuthorizeURL($request_token['oauth_token']);
		} else {
			return null;
		}
	}

	protected function fillUserData(User $user)
	{
		$this->getData();

		$user
			->setTwitterId($this->data->id)
			->setUrl('https://twitter.com/' . $this->data->screen_name)
			->setName(!empty($this->data->name) ? $this->data->name : $this->data->screen_name);

		/*if (!$user->getAvatar() && $this->data->profile_image_url) {
			$this->setUserAvatar($user, str_replace('normal', 'bigger', $this->data->profile_image_url));
		}*/
	}

	/**
	 * @return User
	 */
	protected function findUser()
	{
		$this->getData();

		return $this->getUserService()->getUserByTwitterId($this->data->id);
	}

	protected function getData()
	{
		if ($this->data === null) {
			$request_token = $this->getSessionService()->get('twitter_request_token');
			$connection = new \TwitterOAuth($this->getSettingsService()->get('social.twitter_consumer_key'), $this->getSettingsService()->get('social.twitter_consumer_secret'),
				$request_token['oauth_token'], $request_token['oauth_token_secret']);
			$accessToken = $connection->getAccessToken($this->getRequest()->query->get('oauth_verifier'));
			$this->getSessionService()->uns('twitter_request_token');
			$connection = new \TwitterOAuth($this->getSettingsService()->get('social.twitter_consumer_key'), $this->getSettingsService()->get('social.twitter_consumer_secret'),
				$accessToken['oauth_token'], $accessToken['oauth_token_secret']);
			$this->data = $connection->get('account/verify_credentials');
			if (!isset($this->data->id)) {
				throw new \Exception('Twitter exception: ' . print_r($this->data, true));
			}
		}

		return $this->data;
	}

}