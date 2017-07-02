<?php

namespace Kh\CommentsBundle\Manager;

use Kh\CommentsBundle\Entity\Comment;
use Svi\Manager;

/**
 * Class CommentManager
 * @method static CommentManager getInstance()
 * @package Kh\CommentsBundle\Manager
 */
class CommentManager extends Manager
{

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	public function getDbFieldsDefinition()
	{
		return [
			'id'        => ['id', 'integer', 'id'],
			'userId'    => ['user_id', 'integer', 'index', 'null'],
			'author'    => ['author', 'string', 'length' => 32, 'null'],
			'email'     => ['email', 'string', 'length' => 64, 'null'],
			'url'       => ['url', 'string', 'length' => 64, 'null'],
			'timestamp' => ['timestamp', 'integer', 'index'],
			'ip'        => ['ip', 'string', 'length' => 14],
			'text'      => ['text', 'text', 'null'],
			'postId'    => ['post_id', 'integer', 'index'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'comment';
	}

	public function getEntityClassName()
	{
		return Comment::class;
	}

}