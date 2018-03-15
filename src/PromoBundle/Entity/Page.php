<?php

namespace PromoBundle\Entity;

use Svi\OrmBundle\Entity;

class Page extends Entity
{
	private $id;
	private $title;
	private $text;
	private $uri;
	private $published;

	public function getId()
	{
		return $this->id;
	}

	public function setId($value)
	{
		$this->id = $value;

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

	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setPublished($published)
	{
		$this->published = $published;

		return $this;
	}

	public function getPublished()
	{
		return $this->published;
	}

	public function setUri($uri)
	{
		$this->uri = $uri;

		return $this;
	}

	public function getUri()
	{
		return $this->uri;
	}

	function __toString()
	{
		return (string)$this->getTitle();
	}

}
