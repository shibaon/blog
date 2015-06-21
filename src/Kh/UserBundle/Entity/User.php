<?php

namespace Kh\UserBundle\Entity;

use Svi\Entity;

class User extends Entity
{
	private $id;
	private $role = 'USER';
	private $email;
	private $password;
	private $name;
	private $confirmationHash;
	private $restoreHash;
	private $registerTimestamp;
	private $twitterId;
	private $vkId;
	private $fbId;
	private $url;

	/**
	 * Must return fields in like that: classFieldName => Column schema
	 */
	protected function getFields()
	{
		return [
			'id' =>             ['id', 'integer', 'id'],
			'role' =>           ['role', 'string', 'length' => 16],
			'email' =>          ['email', 'string', 'length' => 64, 'index', 'null'],
			'password' =>       ['password', 'string', 'length' => 128, 'null'],
			'name' => ['name', 'string', 'length' => 64],
			'confirmationHash' => ['confirmation_hash', 'string', 'length' => 32, 'null'],
			'restoreHash' =>    ['restore_hash', 'string', 'length' => 32, 'null'],
			'registerTimestamp' => 	['register_timestamp', 'integer'],
			'twitterId' => ['twitter_id', 'string', 'length' => 32, 'null', 'index'],
			'vkId' => ['vk_id', 'string', 'length' => 32, 'null', 'index'],
			'fbId' => ['fb_id', 'string', 'length' => 32, 'null', 'index'],
			'url' => ['url', 'string', 'length' => 128, 'null'],
		];
	}

	/**
	 * Must return table name in SQL DB where entity stored
	 */
	public function getTableName()
	{
		return 'user';
	}

	/**
	 * @param mixed $confirmationHash
	 * @return User
	 */
	public function setConfirmationHash($confirmationHash)
	{
		$this->confirmationHash = $confirmationHash;
		return $this;
	}

	public function resetConfirmationHash()
	{
		$this->setConfirmationHash(md5(microtime(true) . time() . $this->getEmail()));
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getConfirmationHash()
	{
		return $this->confirmationHash;
	}

	/**
	 * @param mixed $email
	 * @return User
	 */
	public function setEmail($email)
	{
		$this->email = $email;
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
	 * @param mixed $id
	 * @return User
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $password
	 * @return User
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $registerTimestamp
	 * @return User
	 */
	public function setRegisterTimestamp($registerTimestamp)
	{
		$this->registerTimestamp = $registerTimestamp;
		return $this;
	}

	public function resetRegisterTimestamp()
	{
		return $this->setRegisterTimestamp(time());
	}

	/**
	 * @return mixed
	 */
	public function getRegisterTimestamp()
	{
		return $this->registerTimestamp;
	}

	/**
	 * @param mixed $restoreHash
	 * @return User
	 */
	public function setRestoreHash($restoreHash)
	{
		$this->restoreHash = $restoreHash;
		return $this;
	}

	/**
	 * @return User
	 */
	public function resetRestoreHash()
	{
		$this->setRestoreHash(md5($this->getEmail() . microtime(true) . time()));
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRestoreHash()
	{
		return $this->restoreHash;
	}

	/**
	 * @param mixed $role
	 * @return User
	 */
	public function setRole($role)
	{
		$this->role = $role;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRole()
	{
		return $this->role;
	}

	public function isAdmin()
	{
		return $this->role == 'ADMIN';
	}

	public function isEditor()
	{
		return $this->isAdmin() || $this->role == 'EDITOR';
	}

	/**
	 * @param mixed $name
	 * @return User
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getTwitterId()
	{
		return $this->twitterId;
	}

	/**
	 * @param mixed $twitterId
	 * @return User
	 */
	public function setTwitterId($twitterId)
	{
		$this->twitterId = $twitterId;

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
	 * @return User
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVkId()
	{
		return $this->vkId;
	}

	/**
	 * @param mixed $vkId
	 * @return User
	 */
	public function setVkId($vkId)
	{
		$this->vkId = $vkId;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFbId()
	{
		return $this->fbId;
	}

	/**
	 * @param mixed $fbId
	 * @return User
	 */
	public function setFbId($fbId)
	{
		$this->fbId = $fbId;

		return $this;
	}

} 