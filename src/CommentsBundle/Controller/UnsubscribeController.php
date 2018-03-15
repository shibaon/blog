<?php

namespace CommentsBundle\Controller;

use BaseBundle\Controller\Controller;
use CommentsBundle\BundleTrait;
use Svi\HttpBundle\Exception\NotFoundHttpException;

class UnsubscribeController extends Controller
{
    use BundleTrait;

	public function indexAction($hash)
	{
		if (!($subscription = $this->getCommentsSubscriptionService()->getSubscriptionByHash($hash))) {
			throw new NotFoundHttpException;
		}

		$this->getCommentsSubscriptionService()->unsubscribe($hash);
		$this->getAlertsService()->addAlert('success', 'Вы успешно отписались от уведомлений о новых комментариях к этой заметке');

		return $this->redirect($this->generateUrl('_post', array('id' => $subscription->getPostId()->getId())));
	}

}