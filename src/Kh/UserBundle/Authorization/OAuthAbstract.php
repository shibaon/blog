<?php

namespace Kh\UserBundle\Authorization;

use Kh\BaseBundle\ContainerAware;
use Kh\UserBundle\Entity\User;
use Kh\UserBundle\UserManager;
use Sv\BaseBundle\SettingsManager;
use Svi\Application;

abstract class OAuthAbstract extends ContainerAware
{
	function __construct(Application $app)
	{
		parent::__construct($app);
	}

	abstract public function getAuthorizationLink();

	abstract protected function fillUserData(User $user);

	abstract protected function findUser();

	public function authorizationAction()
	{
		$user = $this->findUser();
		if (!$user) {
			$user = $this->getUserManager()->getCurrentUser();
		}
		if (!$user) {
			$user = new User();
			$user->resetRegisterTimestamp();
		}

		$this->fillUserData($user);
		$user->save();
		$this->getUserManager()->login($user);
	}

	protected function setUserAvatar(User $user, $avatar)
	{
		/*$dir = 'avatarsocial/' . substr(md5($avatar), 0, 2);
		if (!file_exists($this->getRootDir() . '/web/files/' . $dir)) {
			mkdir($this->getRootDir() . '/web/files/' . $dir, 0777, true);
		}
		$filename = $dir . '/' . md5($avatar . microtime()) . '.' . pathinfo($avatar, PATHINFO_EXTENSION);
		file_put_contents($this->getRootDir() . '/web/files/' . $filename, fopen($avatar, 'r'));
		$user->setAvatar($filename);*/
	}

	protected function getRootDir()
	{
		return pathinfo($this->c->getApp()->getRootDir(), PATHINFO_DIRNAME);
	}

	/**
	 * @return SettingsManager
	 */
	protected function getSettingsManager()
	{
		return $this->c->getSettingsManager();
	}

	/**
	 * @return UserManager
	 */
	protected function getUserManager()
	{
		return $this->c->getUserManager();
	}

	/**
	 * @return \Svi\Session
	 */
	protected function getSession()
	{
		return $this->c->getApp()->getSession();
	}

	protected function getBackUrl()
	{
		if ($this->getRequest()->query->has('back')) {
			return '?back=' . urlencode($this->getRequest()->query->get('back'));
		} else {
			return '';
		}
	}

	/**
	 * Generates a URL from the given parameters.
	 *
	 * @param string  $route      The name of the route
	 * @param mixed   $parameters An array of parameters
	 * @param Boolean $absolute   Whether to generate an absolute URL
	 *
	 * @return string The generated URL
	 */
	protected function generateUrl($route, $parameters = array(), $absolute = false)
	{
		return $this->c->getRouting()->getUrl($route, $parameters, $absolute);
	}

	protected function getParamString(array $params)
	{
		$result = array();
		foreach ($params as $key => $p) {
			$result[] = urlencode($key) . '=' . urlencode($p);
		}

		return implode('&', $result);
	}

	protected function curlExecute($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($curl);
		curl_close($curl);

		return $content;
	}

}