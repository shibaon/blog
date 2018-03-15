<?php

namespace UserBundle\Service;

use UserBundle\BundleTrait;
use UserBundle\Entity\User;

class UserService extends \Svi\HttpBundle\Service\UserService
{
    use BundleTrait;

	public function getEditors()
	{
		return $this->getUserManager()->findBy(['role' => 'EDITOR']);
	}

	public function getAdmins()
	{
		return $this->getUserManager()->findBy(['role' => 'ADMIN']);
	}

	/**
	 * @param $id
	 * @return User|null
	 */
	public function getUserById($id)
	{
		return $this->getUserManager()->findOneById($id);
	}

	/**
	 * @param $hash
	 * @return User
	 */
	public function getUserByRestoreHash($hash)
	{
		return $this->getUserManager()->findOneByRestoreHash(strtolower($hash));
	}

	/**
	 * @param $hash
	 * @return User
	 */
	public function getUserByConfirmationHash($hash)
	{
		return $this->getUserManager()->findOneByConfirmationHash(strtolower($hash));
	}

	/**
	 * @return null|User
	 */
	public function getCurrentAdmin()
	{
		$user = $this->getCurrentUser();
		if (!$user || !$user->isAdmin()) {
			return null;
		}

		return $user;
	}

	public function getCurrentEditor()
	{
		$user = $this->getCurrentUser();
		if (!$user || !$user->isEditor()) {
			return null;
		}

		return $user;
	}

	/**
	 * @return User
	 */
	public function getCurrentUser()
	{
		return $this->getUserById($this->getAuthorisedUserId());
	}

	public function login(User $user)
	{
		$this->loginUser($user->getId(), true);
		$this->getUserManager()->save($user);
	}

	public function hashPassword($password)
	{
		return hash('sha512', $password);
	}

	public function checkPassword(User $user, $password)
	{
		return $user->getPassword() == $this->hashPassword($password);
	}

	/**
	 * @param $email
	 * @return User
	 */
	public function getUserByEmail($email)
	{
		return $this->getUserManager()->findOneByEmail(strtolower($email));
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByTwitterId($id)
	{
		return $this->getUserManager()->findOneByTwitterId($id);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByVkId($id)
	{
		return $this->getUserManager()->findOneByVkId($id);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByFbId($id)
	{
		return $this->getUserManager()->findOneByFbId($id);
	}

}