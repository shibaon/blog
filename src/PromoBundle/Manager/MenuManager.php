<?php

namespace PromoBundle\Manager;

use PromoBundle\Entity\Menu;
use Svi\OrmBundle\Manager;

class MenuManager extends Manager
{

	/**
	 * Must return fields in like that: DB_field_name => classFieldName
	 */
	public function getDbFieldsDefinition()
	{
		return [
			'id'       => ['id', 'integer', 'id'],
			'title'    => ['title', 'string', 'length' => 32],
			'url'      => ['url', 'string', 'length' => 128, 'null'],
			'weight'   => ['weight', 'smallint', 'null'],
			'parentId' => ['parent_id', 'integer', 'null'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'menu';
	}

	public function getEntityClassName()
	{
		return Menu::class;
	}

}