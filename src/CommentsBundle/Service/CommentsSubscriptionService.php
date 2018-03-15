<?php

namespace CommentsBundle\Service;

use BaseBundle\ContainerAware;
use CommentsBundle\BundleTrait;
use CommentsBundle\Entity\Subscription;
use CommentsBundle\Manager\SubscriptionManager;
use ContentBundle\Entity\Post;

class CommentsSubscriptionService extends ContainerAware
{
    use BundleTrait;

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
		    $this->getManager()->delete($subscription);
		}
	}

	/**
	 * @return SubscriptionManager
	 */
	protected function getManager()
	{
		return $this->getCommentsSubscriptionManager();
	}

}