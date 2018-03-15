<?php

namespace ContentBundle\Entity;

use Svi\OrmBundle\Entity;

class Category extends Entity
{
	private $id;
	private $name;
	private $postsCount = 0;

	public function getPostsCount()
	{
		return $this->postsCount;
	}

	public function setPostsCount($postsCount)
	{
		$this->postsCount = $postsCount;

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

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