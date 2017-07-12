<?php

namespace Kh\CommentsBundle;

use Kh\CommentsBundle\Manager\CommentManager;
use Kh\CommentsBundle\Manager\SubscriptionManager;
use Kh\CommentsBundle\Service\CommentsService;
use Kh\CommentsBundle\Service\CommentsSubscriptionService;

class Bundle extends \Svi\Bundle
{

	public function getRoutes()
	{
		return [
			'Comments'    => [
				'_comments' => '/comments:index',
				'/735cb427f94a5fd53fe00e757e46f57c:delete',
			],
			'Unsubscribe' => [
				'_comments_unsubscribe' => '/comments-unsubscribe/{hash}:index',
			],
		];
	}

	protected function getServices()
	{
		return [
			'service.comments'              => 'Service\CommentsService',
			'service.comments_subscription' => 'Service\CommentsSubscriptionService',
		];
	}

	protected function getManagers()
	{
		return [
			'manager.comment'      => 'Manager\CommentManager',
			'manager.subscription' => 'Manager\SubscriptionManager',
		];
	}

	/**
	 * @return CommentsService
	 */
	public function getCommentsService()
	{
		return $this->getApp()->get('service.comments');
	}

	/**
	 * @return CommentsSubscriptionService
	 */
	public function getCommentsSubscriptionService()
	{
		return $this->getApp()->get('service.comments_subscription');
	}

	/**
	 * @return CommentManager
	 */
	public function getCommentManager()
	{
		return $this->getApp()->get('manager.comment');
	}

	/**
	 * @return SubscriptionManager
	 */
	public function getCommentsSubscriptionManager()
	{
		return $this->getApp()->get('manager.subscription');
	}

}