<?php

namespace Kh\UserBundle\Controller;

use Kh\BaseBundle\Controller\Controller;

class SocialsAuthController extends Controller
{

	public function fbGoAction()
	{
		return $this->redirectToUrl($this->c->getAuthorizationManager()->getFb()->getAuthorizationLink());
	}

	public function fbAction()
	{
		return $this->getReturn(array($this->c->getAuthorizationManager()->getFb(), 'authorizationAction'));
	}

	public function vkGoAction()
	{
		return $this->redirectToUrl($this->c->getAuthorizationManager()->getVk()->getAuthorizationLink());
	}

	public function vkAction()
	{
		return $this->getReturn(array($this->c->getAuthorizationManager()->getVk(), 'authorizationAction'));
	}

	public function twitterGoAction()
	{
		return $this->redirectToUrl($this->c->getAuthorizationManager()->getTwitter()->getAuthorizationLink());
	}

	public function twitterAction()
	{
		return $this->getReturn(array($this->c->getAuthorizationManager()->getTwitter(), 'authorizationAction'));
	}

	protected function getReturn($callback, $exception = false)
	{
		$request = $this->getRequest();
		$exception = false;

		try {
			call_user_func($callback);
		} catch (\Exception $e) {
			$exception = true;
			$this->c->getApp()->getLogger()->write($e->getMessage());
		}

		if ($exception) {
			$this->c->getAlertsManager()->addAlert('danger', 'Авторизация через социальную сеть не удалась');
		} else {
			$this->c->getAlertsManager()->addAlert('success', 'Вы успешно авторизовались');
		}
		$curUser = $this->c->getUserManager()->getCurrentUser();
		if ($request->query->has('back')) {
			return $this->redirectToUrl($request->query->get('back'));
		}
		/*if ($curUser && !$curUser->getEmail()) {
			return $this->redirect($this->generateUrl('_profile_edit'));
		}*/

		return $this->redirect('_login');
	}

}