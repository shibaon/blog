<?php

namespace Kh\ContentBundle;

use Kh\ContentBundle\Manager\CategoryManager;
use Kh\ContentBundle\Manager\PostCategoryManager;
use Kh\ContentBundle\Manager\PostManager;
use Kh\ContentBundle\Service\CategoryService;
use Kh\ContentBundle\Service\PostService;

class Bundle extends \Svi\Bundle
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
		];
	}

	protected function getManagers()
	{
		return [
			CategoryManager::class,
			PostCategoryManager::class,
			PostManager::class,
		];
	}

	/**
	 * @return PostService
	 */
	public function getPostService()
	{
		return $this->getApp()->get(PostService::class);
	}

	/**
	 * @return CategoryService
	 */
	public function getCategoryService()
	{
		return $this->getApp()->get(CategoryService::class);
	}

	/**
	 * @return CategoryManager
	 */
	public function getCategoryManager()
	{
		return $this->getApp()->get(CategoryManager::class);
	}

	/**
	 * @return PostCategoryManager
	 */
	public function getPostCategoryManager()
	{
		return $this->getApp()->get(PostCategoryManager::class);
	}

	/**
	 * @return PostManager
	 */
	public function getPostManager()
	{
		return $this->getApp()->get(PostManager::class);
	}

}