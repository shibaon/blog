<?php

namespace PromoBundle\Entity;

use Svi\CrudBundle\NestedSortableInterface;
use Svi\OrmBundle\Entity;

class Menu extends Entity implements NestedSortableInterface
{
	private $id;
	private $title;
	private $url;
	private $weight;
	private $parentId;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

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
		return (string)$this->title;
	}

	public function getParentId()
	{
		return $this->parentId;
	}

	public function setParentId($parentId = null)
	{
		$this->parentId = $parentId;

		return $this;
	}

}
