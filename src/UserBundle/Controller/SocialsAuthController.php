<?php

namespace UserBundle\Controller;

use BaseBundle\Controller\Controller;
use UserBundle\BundleTrait;

class SocialsAuthController extends Controller
{
    use BundleTrait;

	public function fbGoAction()
	{
		return $this->redirectToUrl($this->getAuthorizationService()->getFb()->getAuthorizationLink());
	}

	public function fbAction()
	{
		return $this->getReturn(array($this->getAuthorizationService()->getFb(), 'authorizationAction'));
	}

	public function vkGoAction()
	{
		return $this->redirectToUrl($this->getAuthorizationService()->getVk()->getAuthorizationLink());
	}

	public function vkAction()
	{
		return $this->getReturn(array($this->getAuthorizationService()->getVk(), 'authorizationAction'));
	}

	public function twitterGoAction()
	{
		return $this->redirectToUrl($this->getAuthorizationService()->getTwitter()->getAuthorizationLink());
	}

	public function twitterAction()
	{
		return $this->getReturn(array($this->getAuthorizationService()->getTwitter(), 'authorizationAction'));
	}

	protected function getReturn($callback, $exception = false)
	{
		$request = $this->getRequest();
		$exception = false;

		try {
			call_user_func($callback);
		} catch (\Exception $e) {
			$exception = true;
			$this->app->getLoggerService()->write($e->getMessage());
		}

		if ($exception) {
			$this->getAlertsService()->addAlert('danger', 'Авторизация через социальную сеть не удалась');
		} else {
			$this->getAlertsService()->addAlert('success', 'Вы успешно авторизовались');
		}
		$curUser = $this->getUserService()->getCurrentUser();
		if ($request->query->has('back')) {
			return $this->redirectToUrl($request->query->get('back'));
		}
		/*if ($curUser && !$curUser->getEmail()) {
			return $this->redirect($this->generateUrl('_profile_edit'));
		}*/

		return $this->redirect('_login');
	}

}