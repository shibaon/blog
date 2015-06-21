<?php

namespace Kh\ContentBundle\Entity;

use Svi\Entity;

class Category extends Entity
{
	private $id;
	private $name;
	private $postsCount;

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id' => ['id', 'integer', 'id'],
			'name' => ['name', 'string', 'length' => 64],
			'postsCount' => ['posts_count', 'smallint'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'category';
	}

	/**
	 * @return mixed
	 */
	public function getPostsCount()
	{
		return $this->postsCount;
	}

	/**
	 * @param mixed $postsCount
	 * @return Category
	 */
	public function setPostsCount($postsCount)
	{
		$this->postsCount = $postsCount;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return Category
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return Category
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	function __toString()
	{
		return $this->getName();
	}

}