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

	protected function getManagers()
	{
		return [
			'comments' => 'Comments',
			'comments_subscription' => 'CommentsSubscription',
		];
	}

}