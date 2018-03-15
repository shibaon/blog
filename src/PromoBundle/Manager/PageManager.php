<?php

namespace PromoBundle\Manager;

use PromoBundle\Entity\Page;
use Svi\OrmBundle\Manager;

class PageManager extends Manager
{

	/**
	 * Must return fields in like that: DB_field_name => classFieldName
	 */
	public function getDbFieldsDefinition()
	{
		return [
			'id'        => ['id', 'integer', 'id'],
			'title'     => ['title', 'string', 'length' => 128],
			'text'      => ['text', 'text', 'null'],
			'uri'       => ['uri', 'string', 'length' => 64, 'null'],
			'published' => ['published', 'boolean'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'page';
	}

	public function getEntityClassName()
	{
		return Page::class;
	}

}