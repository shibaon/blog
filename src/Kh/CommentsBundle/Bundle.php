<?php

namespace Kh\CommentsBundle;

use Kh\CommentsBundle\Manager\CommentManager;
use Kh\CommentsBundle\Manager\SubscriptionManager;
use Kh\CommentsBundle\Service\CommentsService;
use Kh\CommentsBundle\Service\CommentsSubscriptionService;

class Bundle extends \Svi\Service\BundlesService\Bundle
{
    use BundleTrait;

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

}