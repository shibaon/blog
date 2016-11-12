<?php

namespace Kh\UserBundle\Service;

use Kh\UserBundle\Entity\User;

class UserService extends \Svi\Base\Service\UserService
{

	public function getEditors()
	{
		return User::findBy(['role' => 'EDITOR']);
	}

	public function getAdmins()
	{
		return User::findBy(['role' => 'ADMIN']);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserById($id)
	{
		return User::findOneById($id);
	}

	/**
	 * @param $hash
	 * @return User
	 */
	public function getUserByRestoreHash($hash)
	{
		return User::findOneByRestoreHash(strtolower($hash));
	}

	/**
	 * @param $hash
	 * @return User
	 */
	public function getUserByConfirmationHash($hash)
	{
		return User::findOneByConfirmationHash(strtolower($hash));
	}

	/**
	 * @return null|User
	 */
	public function getCurrentAdmin()
	{
		$user = $this->getCurrentUser(true);
		if (!$user || !$user->isAdmin()) {
			return null;
		}

		return $user;
	}

	public function getCurrentEditor()
	{
		$user = $this->getCurrentUser(true);
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
		$user->save();
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
		return User::findOneByEmail(strtolower($email));
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByTwitterId($id)
	{
		return User::findOneByTwitterId($id);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByVkId($id)
	{
		return User::findOneByVkId($id);
	}

	/**
	 * @param $id
	 * @return User
	 */
	public function getUserByFbId($id)
	{
		return User::findOneByFbId($id);
	}

} 