<?php

namespace Kh\ContentBundle\Entity;

use Svi\Entity;

class Category extends Entity
{
	private $id;
	private $name;
	private $postsCount = 0;

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
		return $this->getName() . '';
	}

}