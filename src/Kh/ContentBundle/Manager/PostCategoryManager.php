<?php

namespace Kh\ContentBundle\Manager;

use Svi\Manager;

class PostCategoryManager extends Manager
{

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id'         => ['id', 'integer', 'id'],
			'postId'     => ['post_id', 'integer', 'index'],
			'categoryId' => ['category_id', 'integer', 'index'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	protected function getTableName()
	{
		return 'post_category';
	}

	protected function getEntityClassName()
	{
		return 'Kh\ContentBundle\Entity\PostCategory';
	}

}