<?php

namespace Kh\PromoBundle\Entity;

use Svi\Entity;

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

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return Page
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
	 * Set text
	 *
	 * @param string $text
	 * @return Page
	 */
	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param bool $published
	 */
	public function setPublished($published)
	{
		$this->published = $published;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * @param string $uri
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	function __toString()
	{
		return $this->getTitle();
	}

}
