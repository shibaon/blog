<?php

namespace Kh\CommentsBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnsubscribeController extends Controller
{

	public function indexAction($hash)
	{
		if (!($subscription = $this->c->getCommentsSubscriptionService()->getSubscriptionByHash($hash))) {
			throw new NotFoundHttpException;
		}

		$this->c->getCommentsSubscriptionService()->unsubscribe($hash);
		$this->c->getAlertsService()->addAlert('success', 'Вы успешно отписались от уведомлений о новых комментариях к этой заметке');

		return $this->redirect($this->generateUrl('_post', array('id' => $subscription->getPostId()->getId())));
	}

}