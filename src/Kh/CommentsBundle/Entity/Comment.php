<?php

namespace Kh\CommentsBundle\Entity;

use Kh\ContentBundle\Entity\Post;
use Kh\UserBundle\Entity\User;
use Svi\Entity;

class Comment extends Entity
{
	private $id;
	private $userId;
	private $author;
	private $email;
	private $url;
	private $timestamp;
	private $ip;
	private $text;
	private $postId;

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id' => ['id', 'integer', 'id'],
			'userId' => ['user_id', 'integer', 'index', 'null'],
			'author' => ['author', 'string', 'length' => 32, 'null'],
			'email' => ['email', 'string', 'length' => 64, 'null'],
			'url' => ['url', 'string', 'length' => 64, 'null'],
			'timestamp' => ['timestamp', 'integer', 'index'],
			'ip' => ['ip', 'string', 'length' => 14],
			'text' => ['text', 'text', 'null'],
			'postId' => ['post_id', 'integer', 'index'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'comment';
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
	 * @return Comment
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return User::findOneById($this->getUserId());
	}

	/**
	 * @param mixed $userId
	 * @return Comment
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param mixed $author
	 * @return Comment
	 */
	public function setAuthor($author)
	{
		$this->author = $author;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 * @return Comment
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param mixed $url
	 * @return Comment
	 */
	public function setUrl($url)
	{
		$this->url = $url;

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
	 * @return Comment
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
	public function getIp()
	{
		return $this->ip;
	}

	/**
	 * @param mixed $ip
	 * @return Comment
	 */
	public function setIp($ip)
	{
		$this->ip = $ip;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param mixed $text
	 * @return Comment
	 */
	public function setText($text)
	{
		$this->text = $text;

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
	 * @return Comment
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;

		return $this;
	}

}