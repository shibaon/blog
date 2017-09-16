<?php

namespace Kh\PromoBundle;

use Kh\PromoBundle\Manager\MenuManager;
use Kh\PromoBundle\Manager\PageManager;
use Kh\PromoBundle\Service\MenuService;
use Kh\PromoBundle\Service\PageService;

class Bundle extends \Svi\Bundle
{

	public function getRoutes()
	{
		return [
			'AdminPage' => [
				'_admin_pages'        => '/admin/pages:index',
				'_admin_pages_add'    => '/admin/pages/add:add',
				'_admin_pages_edit'   => '/admin/pages/edit/{id}:edit',
				'_admin_pages_delete' => '/admin/pages/delete/{id}:delete',
			],
			'AdminMenu' => [
				'_admin_menu'        => '/admin/menu:index',
				'_admin_menu_add'    => '/admin/menu/add:add',
				'_admin_menu_edit'   => '/admin/menu/edit/{id}:edit',
				'_admin_menu_delete' => '/admin/menu/delete/{id}:delete',
			],
			'Front'     => [
				'_front' => '/:index',
			],
			'Banner'    => [
				'_banner' => '/banner/{id}:redirect',
			],


			// Should be last for catching routes which was not defined
			'Page'      => [
				'_page' => [
					'route'        => '/{page}',
					'requirements' => [
						'page' => '.*',
					],
					'method'       => 'page',
				],
			],
		];
	}

	protected function getServices()
	{
		return [
			MenuService::class,
			PageService::class,
		];
	}

	protected function getManagers()
	{
		return [
			MenuManager::class,
			PageManager::class,
		];
	}

	/**
	 * @return MenuService
	 */
	public function getMenuService()
	{
		return $this->getApp()->get(MenuService::class);
	}

	/**
	 * @return PageService
	 */
	public function getPageService()
	{
		return $this->getApp()->get(PageService::class);
	}

	/**
	 * @return MenuManager
	 */
	public function getMenuManager()
	{
		return $this->getApp()->get(MenuManager::class);
	}

	/**
	 * @return PageManager
	 */
	public function getPageManager()
	{
		return $this->getApp()->get(PageManager::class);
	}

} 