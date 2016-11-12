<?php

namespace Kh\UserBundle\Controller;

use Kh\BaseBundle\Controller\Controller;

class SocialsAuthController extends Controller
{

	public function fbGoAction()
	{
		return $this->redirectToUrl($this->c->getAuthorizationService()->getFb()->getAuthorizationLink());
	}

	public function fbAction()
	{
		return $this->getReturn(array($this->c->getAuthorizationService()->getFb(), 'authorizationAction'));
	}

	public function vkGoAction()
	{
		return $this->redirectToUrl($this->c->getAuthorizationService()->getVk()->getAuthorizationLink());
	}

	public function vkAction()
	{
		return $this->getReturn(array($this->c->getAuthorizationService()->getVk(), 'authorizationAction'));
	}

	public function twitterGoAction()
	{
		return $this->redirectToUrl($this->c->getAuthorizationService()->getTwitter()->getAuthorizationLink());
	}

	public function twitterAction()
	{
		return $this->getReturn(array($this->c->getAuthorizationService()->getTwitter(), 'authorizationAction'));
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
			$this->c->getAlertsService()->addAlert('danger', 'Авторизация через социальную сеть не удалась');
		} else {
			$this->c->getAlertsService()->addAlert('success', 'Вы успешно авторизовались');
		}
		$curUser = $this->c->getUserService()->getCurrentUser();
		if ($request->query->has('back')) {
			return $this->redirectToUrl($request->query->get('back'));
		}
		/*if ($curUser && !$curUser->getEmail()) {
			return $this->redirect($this->generateUrl('_profile_edit'));
		}*/

		return $this->redirect('_login');
	}

}