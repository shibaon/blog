<?php

namespace Kh\UserBundle;

use Kh\UserBundle\Manager\UserManager;
use Kh\UserBundle\Service\AuthorizationService;
use Kh\UserBundle\Service\UserService;

class Bundle extends \Svi\Bundle
{

	public function getRoutes()
	{
		return [
			'User'        => [
				'_login'         => '/login:login',
				'_register'      => '/register:register',
				'_confirm'       => '/confirm/{hash}:confirm',
				'_logout'        => '/logout:logout',
				'_profile_edit'  => '/profile/edit:profileEdit',
				'_restore'       => '/restore:restore',
				'_restore_final' => '/restore/{hash}:restoreFinal',
			],
			'SocialsAuth' => [
				'_twitter_go'                     => '/twitter/go:twitterGo',
				'_twitter_authorization_redirect' => '/twitter/auth-redirect:twitter',
				'_vk_go'                          => '/vk/go:vkGo',
				'_vk_redirect'                    => '/vk/auth-redirect:vk',
				'_fb_go'                          => '/fb/go:fbGo',
				'_fb_redirect'                    => '/fb/auth-redirect:fb',
			],
		];
	}

	protected function getServices()
	{
		return [
			'service.user'          => 'Service\UserService',
			'service.authorization' => 'Service\AuthorizationService',
		];
	}

	protected function getManagers()
	{
		return [
			'manager.user' => 'Manager\UserManager',
		];
	}

	/**
	 * @return UserService
	 */
	public function getUserService()
	{
		return $this->getApp()->get('service.user');
	}

	/**
	 * @return AuthorizationService
	 */
	public function getAuthorizationService()
	{
		return $this->getApp()->get('service.authorization');
	}

	/**
	 * @return UserManager
	 */
	public function getUserManager()
	{
		return $this->getApp()->get('manager.user');
	}

} 