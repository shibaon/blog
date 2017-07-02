<?php

namespace Kh\UserBundle\Manager;

use Kh\UserBundle\Entity\User;
use Svi\Manager;

/**
 * Class UserManager
 * @method static UserManager getInstance
 * @package Kh\UserBundle\Manager
 */
class UserManager extends Manager
{

	public function getDbFieldsDefinition()
	{
		return [
			'id'                => ['id', 'integer', 'id'],
			'role'              => ['role', 'string', 'length' => 16],
			'email'             => ['email', 'string', 'length' => 64, 'index', 'null'],
			'password'          => ['password', 'string', 'length' => 128, 'null'],
			'name'              => ['name', 'string', 'length' => 64],
			'confirmationHash'  => ['confirmation_hash', 'string', 'length' => 32, 'null'],
			'restoreHash'       => ['restore_hash', 'string', 'length' => 32, 'null'],
			'registerTimestamp' => ['register_timestamp', 'integer'],
			'twitterId'         => ['twitter_id', 'string', 'length' => 32, 'null', 'index'],
			'vkId'              => ['vk_id', 'string', 'length' => 32, 'null', 'index'],
			'fbId'              => ['fb_id', 'string', 'length' => 32, 'null', 'index'],
			'url'               => ['url', 'string', 'length' => 128, 'null'],
		];
	}

	public function getTableName()
	{
		return 'user';
	}

	public function getEntityClassName()
	{
		return User::class;
	}

}