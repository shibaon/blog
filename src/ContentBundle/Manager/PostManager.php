<?php

namespace ContentBundle\Manager;

use ContentBundle\Entity\Post;
use Svi\OrmBundle\Manager;

/**
 * Class PostManager
 * @package ContentBundle\Manager
 */
class PostManager extends Manager
{

	public function getDbFieldsDefinition()
	{
		return [
			'id'            => ['id', 'integer', 'id'],
			'userId'        => ['user_id', 'integer'],
			'title'         => ['title', 'string', 'length' => 128],
			'text'          => ['text', 'text', 'null'],
			'published'     => ['published', 'boolean', 'index'],
			'timestamp'     => ['timestamp', 'integer', 'index'],
			'alias'         => ['alias', 'string', 'length' => 128, 'null', 'index'],
			'commentsCount' => ['comments_count', 'smallint'],
			'removed'       => ['removed', 'boolean', 'index'],
		];
	}

	public function getTableName()
	{
		return 'post';
	}

	public function getEntityClassName()
	{
		return Post::class;
	}

}