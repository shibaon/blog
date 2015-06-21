<?php

namespace Kh\ContentBundle\Entity;

class Post extends \Svi\Entity implements \Sv\CrudBundle\Entity\RemovableInterface
{
	private $id;
	private $title;
	private $text;
	private $published = true;
	private $timestamp;
	private $alias;
	private $commentsCount = 0;
	private $removed = false;

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id' => ['id', 'integer', 'id'],
			'title' => ['title', 'string', 'length' => 128],
			'text' => ['text', 'text', 'null'],
			'published' => ['published', 'boolean', 'index'],
			'timestamp' => ['timestamp', 'integer', 'index'],
			'alias' => ['alias', 'string', 'length' => 128, 'null', 'index'],
			'commentsCount' => ['comments_count', 'smallint'],
			'removed' => ['removed', 'boolean', 'index'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'post';
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
	 * @return Post
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 * @return Post
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getText()
	{
		return $this->text;
	}

	public function getShortenedText()
	{
		$text = $this->getText();

		if ($pos = mb_strpos($text, '<p>==more==</p>')) {
			return substr($text, 0, $pos) . '<p><a class="readMoreLink" href="%readMoreLink%#readMore">%readMoreLinkText%</a></p>';
		}

		return $text;
	}

	public function getFullText()
	{
		$text = $this->getText();

		if ($pos = mb_strpos($text, '<p>==more==</p>')) {
			return str_replace('<p>==more==</p>', '<span class="readMoreAnchor" id="readMore"></span>', $text);
		}

		return $text;
	}

	/**
	 * @param mixed $text
	 * @return Post
	 */
	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * @param boolean $published
	 * @return Post
	 */
	public function setPublished($published)
	{
		$this->published = $published;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * @param mixed $timestamp
	 * @return Post
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;

		return $this;
	}

	public function resetTimestamp()
	{
		return $this->setTimestamp(time());
	}

	/**
	 * @return mixed
	 */
	public function getAlias()
	{
		return $this->alias;
	}

	/**
	 * @param mixed $alias
	 * @return Post
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCommentsCount()
	{
		return $this->commentsCount;
	}

	/**
	 * @param int $commentsCount
	 * @return Post
	 */
	public function setCommentsCount($commentsCount)
	{
		$this->commentsCount = $commentsCount;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getRemoved()
	{
		return $this->removed;
	}

	/**
	 * @param boolean $removed
	 * @return Post
	 */
	public function setRemoved($removed)
	{
		$this->removed = $removed;

		return $this;
	}

	public function remove()
	{
		return $this->setRemoved(true);
	}

	function __toString()
	{
		return $this->getTitle();
	}

}