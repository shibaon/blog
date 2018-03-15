<?php

namespace UserBundle\Service;

use Svi\AppContainer;
use UserBundle\Authorization\Fb;
use UserBundle\Authorization\Twitter;
use UserBundle\Authorization\Vk;

class AuthorizationService extends AppContainer
{
	static private $vk;
	static private $twitter;
	static private $fb;

	/**
	 * @return Vk
	 */
	public function getVk()
	{
		if (!self::$vk) {
			self::$vk = new Vk($this->app);
		}

		return self::$vk;
	}

	public function getTwitter()
	{
		if (!self::$twitter) {
			self::$twitter = new Twitter($this->app);
		}

		return self::$twitter;
	}

	public function getFb()
	{
		if (!self::$fb) {
			self::$fb = new Fb($this->app);
		}

		return self::$fb;
	}

}