<?php

namespace Kh\ContentBundle\Entity;

use Svi\Entity;

class PostCategory extends Entity
{
	private $id;
	private $postId;
	private $categoryId;

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id'         => ['id', 'integer', 'id'],
			'postId'     => ['post_id', 'integer', 'index'],
			'categoryId' => ['category_id', 'integer', 'index'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'post_category';
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
	 * @return PostCategory
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostId()
	{
		return $this->postId;
	}

	/**
	 * @return Post
	 */
	public function getPost()
	{
		return Post::findOneById($this->getPostId());
	}

	/**
	 * @param mixed $postId
	 * @return PostCategory
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCategoryId()
	{
		return $this->categoryId;
	}

	/**
	 * @return Category
	 */
	public function getCategory()
	{
		return Category::findOneById($this->getCategoryId());
	}

	/**
	 * @param mixed $categoryId
	 * @return PostCategory
	 */
	public function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;

		return $this;
	}

}