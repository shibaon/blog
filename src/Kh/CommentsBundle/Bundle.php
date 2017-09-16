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
			CommentsService::class,
			CommentsSubscriptionService::class,
		];
	}

	protected function getManagers()
	{
		return [
			CommentManager::class,
			SubscriptionManager::class,
		];
	}

	/**
	 * @return CommentsService
	 */
	public function getCommentsService()
	{
		return $this->getApp()->get(CommentsService::class);
	}

	/**
	 * @return CommentsSubscriptionService
	 */
	public function getCommentsSubscriptionService()
	{
		return $this->getApp()->get(CommentsSubscriptionService::class);
	}

	/**
	 * @return CommentManager
	 */
	public function getCommentManager()
	{
		return $this->getApp()->get(CommentManager::class);
	}

	/**
	 * @return SubscriptionManager
	 */
	public function getCommentsSubscriptionManager()
	{
		return $this->getApp()->get(SubscriptionManager::class);
	}

}