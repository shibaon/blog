<?php

namespace Kh\CommentsBundle\Service;

use Kh\BaseBundle\ContainerAware;
use Kh\CommentsBundle\Entity\Subscription;
use Kh\CommentsBundle\Manager\SubscriptionManager;
use Kh\ContentBundle\Entity\Post;

class CommentsSubscriptionService extends ContainerAware
{

	/**
	 * @param Post $post
	 * @param $email
	 * @return Subscription
	 */
	public function getSubscriptionByArgs(Post $post, $email)
	{
		return $this->getManager()->findOneBy(['post_id' => $post->getId(), 'email' => strtolower($email)]);
	}

	public function subscribe(Post $post, $email)
	{
		$subscription = $this->getSubscriptionByArgs($post, $email);
		if (!$subscription) {
			$subscription = new Subscription();
			$subscription
				->setEmail(strtolower($email))
				->setPostId($post->getId())
				->setHash(md5($email . microtime(true)));

			$this->getManager()->save($subscription);
		}

		return $subscription;
	}

	public function getSubscribes(Post $post)
	{
		return $this->getManager()->findByPostId($post->getId());
	}

	/**
	 * @param $hash
	 * @return Subscription
	 */
	public function getSubscriptionByHash($hash)
	{
		return $this->getManager()->findOneByHash($hash);
	}

	public function unsubscribe($hash)
	{
		$subscription = $this->getSubscriptionByHash($hash);
		if ($subscription) {
			$subscription->delete();
		}
	}

	/**
	 * @return SubscriptionManager
	 */
	protected function getManager()
	{
		return $this->c->getCommentsBundle()->getCommentsSubscriptionManager();
	}

}