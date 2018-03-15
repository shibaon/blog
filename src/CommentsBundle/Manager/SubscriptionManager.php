<?php

namespace CommentsBundle\Manager;

use CommentsBundle\Entity\Subscription;
use Svi\OrmBundle\Manager;

class SubscriptionManager extends Manager
{

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	public function getDbFieldsDefinition()
	{
		return [
			'id'     => ['id', 'integer', 'id'],
			'email'  => ['email', 'string', 'length' => 64],
			'postId' => ['post_id', 'integer', 'index'],
			'hash'   => ['hash', 'string', 'length' => 32],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'comments_subscription';
	}

	public function getEntityClassName()
	{
		return Subscription::class;
	}

}