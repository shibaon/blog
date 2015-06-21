<?php

namespace Kh\UserBundle;

use Kh\BaseBundle\ContainerAware;
use Kh\UserBundle\Authorization\Fb;
use Kh\UserBundle\Authorization\Twitter;
use Kh\UserBundle\Authorization\Vk;

class AuthorizationManager extends ContainerAware
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
			self::$vk = new Vk($this->c->getApp());
		}

		return self::$vk;
	}

	public function getTwitter()
	{
		if (!self::$twitter) {
			self::$twitter = new Twitter($this->c->getApp());
		}

		return self::$twitter;
	}

	public function getFb()
	{
		if (!self::$fb) {
			self::$fb = new Fb($this->c->getApp());
		}

		return self::$fb;
	}

}