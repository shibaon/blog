<?php

namespace UserBundle\Authorization;

use BaseBundle\Service\SettingsService;
use Svi\AppContainer;
use Svi\HttpBundle\Service\HttpService;
use Svi\HttpBundle\Service\RoutingService;
use Svi\HttpBundle\Service\SessionService;
use UserBundle\BundleTrait;
use UserBundle\Entity\User;

abstract class OAuthAbstract extends AppContainer
{
    use BundleTrait;

	abstract public function getAuthorizationLink();

	abstract protected function fillUserData(User $user);

	abstract protected function findUser();

	public function authorizationAction()
	{
		$user = $this->findUser();
		if (!$user) {
			$user = $this->getUserService()->getCurrentUser();
		}
		if (!$user) {
			$user = new User();
			$user->resetRegisterTimestamp();
		}

		$this->fillUserData($user);
		$this->getUserManager()->save($user);
		$this->getUserService()->login($user);
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
		return pathinfo($this->app->getRootDir(), PATHINFO_DIRNAME);
	}

	/**
	 * @return SettingsService
	 */
	protected function getSettingsService()
	{
	    return $this->app[SettingsService::class];
	}

	/**
	 * @return SessionService
	 */
	protected function getSessionService()
	{
		return $this->app[SessionService::class];
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
		return $this->app[RoutingService::class]->getUrl($route, $parameters, $absolute);
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

	protected function getRequest()
    {
        return $this->app[HttpService::class]->getRequest();
    }

}