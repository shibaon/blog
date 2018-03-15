<?php

namespace ContentBundle\Manager;

use ContentBundle\Entity\PostCategory;
use Svi\OrmBundle\Manager;

class PostCategoryManager extends Manager
{

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	public function getDbFieldsDefinition()
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
	public function getTableName()
	{
		return 'post_category';
	}

	public function getEntityClassName()
	{
		return PostCategory::class;
	}

}