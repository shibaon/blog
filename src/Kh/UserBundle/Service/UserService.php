<?php

namespace Kh\UserBundle\Service;

use Kh\UserBundle\Entity\User;
use Kh\UserBundle\Manager\UserManager;

class UserService extends \Svi\Base\Service\UserService
{

	public function getEditors()
	{
		return $this->getManager()->findBy(['role' => 'EDITOR']);
	}

	public function getAdmins()
	{
		return $this->getManager()->findBy(['role' => 'ADMIN']);
	}

	/**
	 * @param $id
	 * @return User|null
	 */
	public function getUserById($id)
	{
		return $this->getManager()->findOneById($id);
	}

	/**
	 * @param $hash
	 * @return User
	 */
	public function getUserByRestoreHash($hash)
	{
		return $this->getManager()->findOneByRestoreHash(strtolower($hash));
	}

	/**
	 * @param $hash
	 * @return User
	 */
	public function getUserByConfirmationHash($hash)
	{
		return $this->getManager()->findOneByConfirmationHash(strtolower($hash));
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
		$this->getManager()->save($user);
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
		return $this->getManager()->findOneByEmail(strtolower($email));
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByTwitterId($id)
	{
		return $this->getManager()->findOneByTwitterId($id);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByVkId($id)
	{
		return $this->getManager()->findOneByVkId($id);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByFbId($id)
	{
		return $this->getManager()->findOneByFbId($id);
	}

	/**
	 * @return UserManager
	 */
	protected function getManager()
	{
		return $this->c->getApp()->get(UserManager::class);
	}

}