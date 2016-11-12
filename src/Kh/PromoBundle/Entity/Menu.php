<?php

namespace Kh\PromoBundle\Entity;

use Svi\Crud\Entity\NestedSortableInterface;
use Svi\Entity;

class Menu extends Entity implements NestedSortableInterface
{
	private $id;
	private $title;
	private $url;
	private $weight;
	private $parentId;

	/**
	 * Must return fields in like that: DB_field_name => classFieldName
	 */
	public function getFields()
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

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return Menu
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return Menu
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set url
	 *
	 * @param string $url
	 * @return Menu
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;

		return $this;
	}

	function __toString()
	{
		return $this->title;
	}

	/**
	 * @return mixed
	 */
	public function getParentId()
	{
		return $this->parentId;
	}

	/**
	 * @param mixed $parentId
	 * @return Menu
	 */
	public function setParentId($parentId = null)
	{
		$this->parentId = $parentId;

		return $this;
	}

}
