<?php

namespace Kh\ContentBundle\Manager;

use Kh\ContentBundle\Entity\Category;
use Svi\Manager;

/**
 * Class CategoryManager
 * @method static CategoryManager getInstance()
 * @package Kh\ContentBundle\Manager
 */
class CategoryManager extends Manager
{

	public function getDbFieldsDefinition()
	{
		return [
			'id'         => ['id', 'integer', 'id'],
			'name'       => ['name', 'string', 'length' => 64],
			'postsCount' => ['posts_count', 'smallint'],
		];
	}

	public function getTableName()
	{
		return 'category';
	}

	public function getEntityClassName()
	{
		return Category::class;
	}


}