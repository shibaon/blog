<?php

namespace PromoBundle;

use PromoBundle\Manager\MenuManager;
use PromoBundle\Manager\PageManager;
use PromoBundle\Service\MenuService;
use PromoBundle\Service\PageService;

class Bundle extends \Svi\Service\BundlesService\Bundle
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
				'_page' => '/{page}:page',
			],
		];
	}

	protected function getServices()
	{
		return [
			MenuService::class,
			PageService::class,
            MenuManager::class,
            PageManager::class,
		];
	}

} 