<?php

namespace ContentBundle;

use ContentBundle\Manager\CategoryManager;
use ContentBundle\Manager\PostCategoryManager;
use ContentBundle\Manager\PostManager;
use ContentBundle\Service\CategoryService;
use ContentBundle\Service\PostService;

class Bundle extends \Svi\Service\BundlesService\Bundle
{
	public function getRoutes()
	{
		return [
			'AdminPost'     => [
				'_admin_post'        => '/admin/post:index',
				'_admin_post_add'    => '/admin/post/add:add',
				'_admin_post_edit'   => '/admin/post/{id}/edit:edit',
				'_admin_post_delete' => '/admin/post/{id}/delete:delete',
			],
			'AdminCategory' => [
				'_admin_category'        => '/admin/category:index',
				'_admin_category_add'    => '/admin/category/add:add',
				'_admin_category_edit'   => '/admin/category/{id}/edit:edit',
				'_admin_category_delete' => '/admin/category/{id}/delete:delete',
			],
			'Category'      => [
				'_category' => '/c/{id}:index',
			],
			'Rss'           => [
				'_rss' => '/rss:index',
				'/feed:feed',
			],
			'Post'          => [
				'_post' => '/p/{id}:index',
			],
		];
	}

	protected function getServices()
	{
		return [
			PostService::class,
			CategoryService::class,
            CategoryManager::class,
            PostCategoryManager::class,
            PostManager::class,
		];
	}

}