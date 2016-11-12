<?php

namespace Kh\CommentsBundle;

class Bundle extends \Svi\Bundle
{

	public function getRoutes()
	{
		return [
			'Comments' => [
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
			'service.comments' => 'Service\CommentsService',
			'service.comments_subscription' => 'Service\CommentsSubscriptionService',
		];
	}

}