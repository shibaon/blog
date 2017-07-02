<?php

namespace Kh\ContentBundle\Entity;

use Kh\ContentBundle\Manager\CategoryManager;
use Kh\ContentBundle\Manager\PostManager;
use Svi\Entity;

class PostCategory extends Entity
{
	private $id;
	private $postId;
	private $categoryId;

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
		return PostManager::getInstance()->findOneById($this->getPostId());
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
		return CategoryManager::getInstance()->findOneById($this->getCategoryId());
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