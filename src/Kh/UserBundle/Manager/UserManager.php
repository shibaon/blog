<?php

namespace Kh\UserBundle\Manager;

use Svi\Manager;

class UserManager extends Manager
{

	protected function getFields()
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

	protected function getTableName()
	{
		return 'user';
	}

	protected function getEntityClassName()
	{
		return 'Kh\UserBundle\Entity\User';
	}

}