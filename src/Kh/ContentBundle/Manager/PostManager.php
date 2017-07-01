<?php

namespace Kh\ContentBundle\Manager;

use Svi\Manager;

class PostManager extends Manager
{

	protected function getFields()
	{
		return [
			'id'            => ['id', 'integer', 'id'],
			'title'         => ['title', 'string', 'length' => 128],
			'text'          => ['text', 'text', 'null'],
			'published'     => ['published', 'boolean', 'index'],
			'timestamp'     => ['timestamp', 'integer', 'index'],
			'alias'         => ['alias', 'string', 'length' => 128, 'null', 'index'],
			'commentsCount' => ['comments_count', 'smallint'],
			'removed'       => ['removed', 'boolean', 'index'],
		];
	}

	protected function getTableName()
	{
		return 'post';
	}

	protected function getEntityClassName()
	{
		return 'Kh\ContentBundle\Entity\Post';
	}

}