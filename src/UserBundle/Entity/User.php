<?php

namespace UserBundle\Entity;

use Svi\OrmBundle\Entity;

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

	public function getConfirmationHash()
	{
		return $this->confirmationHash;
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setRegisterTimestamp($registerTimestamp)
	{
		$this->registerTimestamp = $registerTimestamp;

		return $this;
	}

	public function resetRegisterTimestamp()
	{
		return $this->setRegisterTimestamp(time());
	}

	public function getRegisterTimestamp()
	{
		return $this->registerTimestamp;
	}

	public function setRestoreHash($restoreHash)
	{
		$this->restoreHash = $restoreHash;

		return $this;
	}

	public function resetRestoreHash()
	{
		$this->setRestoreHash(md5($this->getEmail() . microtime(true) . time()));

		return $this;
	}

	public function getRestoreHash()
	{
		return $this->restoreHash;
	}

	public function setRole($role)
	{
		$this->role = $role;

		return $this;
	}

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

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getTwitterId()
	{
		return $this->twitterId;
	}

	public function setTwitterId($twitterId)
	{
		$this->twitterId = $twitterId;

		return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	public function getVkId()
	{
		return $this->vkId;
	}

	public function setVkId($vkId)
	{
		$this->vkId = $vkId;

		return $this;
	}

	public function getFbId()
	{
		return $this->fbId;
	}

	public function setFbId($fbId)
	{
		$this->fbId = $fbId;

		return $this;
	}

} 