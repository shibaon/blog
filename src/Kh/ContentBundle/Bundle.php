<?php

namespace Kh\ContentBundle;

class Bundle extends \Svi\Bundle
{

	public function getRoutes()
	{
		return [
			'AdminPost' => [
				'_admin_post' => '/admin/post:index',
				'_admin_post_add' => '/admin/post/add:add',
				'_admin_post_edit' => '/admin/post/{id}/edit:edit',
				'_admin_post_delete' => '/admin/post/{id}/delete:delete',
			],
			'AdminCategory' => [
				'_admin_category' => '/admin/category:index',
				'_admin_category_add' => '/admin/category/add:add',
				'_admin_category_edit' => '/admin/category/{id}/edit:edit',
				'_admin_category_delete' => '/admin/category/{id}/delete:delete',
			],
			'Category' => [
				'_category' => '/c/{id}:index',
			],
			'Rss' => [
				'_rss' => '/rss:index',
				'/feed:feed',
			],
			'Post' => [
				'_post' => '/p/{id}:index',
			],
		];
	}

	protected function getManagers()
	{
		return [
			'post' => 'Post',
			'category' => 'Category',
		];
	}

}