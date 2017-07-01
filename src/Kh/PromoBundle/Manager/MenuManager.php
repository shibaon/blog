<?php

namespace Kh\PromoBundle\Manager;

use Svi\Manager;

class MenuManager extends Manager
{

	/**
	 * Must return fields in like that: DB_field_name => classFieldName
	 */
	protected function getFields()
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
	protected function getTableName()
	{
		return 'menu';
	}

	protected function getEntityClassName()
	{
		return '\Kh\PromoBundle\Entity\Menu';
	}

}