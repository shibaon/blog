<?php

namespace Kh\ContentBundle\Manager;

use Svi\Manager;

class CategoryManager extends Manager
{

	protected function getFields()
	{
		return [
			'id'         => ['id', 'integer', 'id'],
			'name'       => ['name', 'string', 'length' => 64],
			'postsCount' => ['posts_count', 'smallint'],
		];
	}

	protected function getTableName()
	{
		return 'category';
	}

	protected function getEntityClassName()
	{
		return 'Kh\ContentBundle\Entity\Category';
	}


}