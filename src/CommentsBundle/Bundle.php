<?php

namespace CommentsBundle;

use CommentsBundle\Manager\CommentManager;
use CommentsBundle\Manager\SubscriptionManager;
use CommentsBundle\Service\CommentsService;
use CommentsBundle\Service\CommentsSubscriptionService;

class Bundle extends \Svi\Service\BundlesService\Bundle
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
            CommentManager::class,
            SubscriptionManager::class,
		];
	}

}