<?php

namespace Kh\CommentsBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnsubscribeController extends Controller
{

	public function indexAction($hash)
	{
		if (!($subscription = $this->c->getCommentsSubscriptionManager()->getSubscriptionByHash($hash))) {
			throw new NotFoundHttpException;
		}

		$this->c->getCommentsSubscriptionManager()->unsubscribe($hash);
		$this->c->getAlertsManager()->addAlert('success', 'Вы успешно отписались от уведомлений о новых комментариях к этой заметке');

		return $this->redirect($this->generateUrl('_post', array('id' => $subscription->getPostId()->getId())));
	}

}