<?php

namespace Kh\CommentsBundle;

use Kh\BaseBundle\ContainerAware;
use Kh\CommentsBundle\Entity\Subscription;
use Kh\ContentBundle\Entity\Post;

class CommentsSubscriptionManager extends ContainerAware
{

	/**
	 * @param Post $post
	 * @param $email
	 * @return Subscription
	 */
	public function getSubscriptionByArgs(Post $post, $email)
	{
		return Subscription::findOneBy(['postId' => $post->getId(), 'email' => strtolower($email)]);
	}

	public function subscribe(Post $post, $email)
	{
		$subscription = $this->getSubscriptionByArgs($post, $email);
		if (!$subscription) {
			$subscription = new Subscription();
			$subscription
				->setEmail(strtolower($email))
				->setPostId($post->getId())
				->setHash(md5($email . microtime(true)))
				->save();
		}

		return $subscription;
	}

	public function getSubscribes(Post $post)
	{
		return Subscription::findByPostId($post->getId());
	}

	/**
	 * @param $hash
	 * @return Subscription
	 */
	public function getSubscriptionByHash($hash)
	{
		return Subscription::findOneByHash($hash);
	}

	public function unsubscribe($hash)
	{
		$subscription = $this->getSubscriptionByHash($hash);
		if ($subscription) {
			$subscription->delete();
		}
	}

}