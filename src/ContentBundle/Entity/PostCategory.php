<?php

namespace ContentBundle\Entity;

use Svi\OrmBundle\Entity;

class PostCategory extends Entity
{
	private $id;
	private $postId;
	private $categoryId;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getPostId()
	{
		return $this->postId;
	}

	public function setPostId($postId)
	{
		$this->postId = $postId;

		return $this;
	}

	public function getCategoryId()
	{
		return $this->categoryId;
	}

	public function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;

		return $this;
	}

}