<?php

namespace ContentBundle\Manager;

use ContentBundle\Entity\Category;
use Svi\OrmBundle\Manager;

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