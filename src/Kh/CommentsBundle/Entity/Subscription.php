<?php

namespace Kh\CommentsBundle\Entity;

use Svi\Entity;

class Subscription extends Entity
{
	private $id;
	private $email;
	private $postId;
	private $hash;

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id'     => ['id', 'integer', 'id'],
			'email'  => ['email', 'string', 'length' => 64],
			'postId' => ['post_id', 'integer', 'index'],
			'hash'   => ['hash', 'string', 'length' => 32],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'comments_subscription';
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
	 * @return Subscription
	 */
	public function setId($id)
	{
		$this->id = $id;

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
	 * @return Subscription
	 */
	public function setEmail($email)
	{
		$this->email = $email;

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
	 * @param mixed $postId
	 * @return Subscription
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * @param mixed $hash
	 * @return Subscription
	 */
	public function setHash($hash)
	{
		$this->hash = $hash;

		return $this;
	}

}