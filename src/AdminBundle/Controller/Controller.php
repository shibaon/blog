<?php

namespace AdminBundle\Controller;

use UserBundle\Service\UserService;

abstract class Controller extends \BaseBundle\Controller\Controller
{

	public static function getMenu()
	{
		return [
			'posts' => [
				'title' => 'Содержимое',
				'noLink' => true,
				'items' => [
					'_admin_post' => [
						'title' => 'Заметки',
					],
					'_admin_category' => [
						'title' => 'Категории',
					],
				],
			],
			'promo' => [
				'title' => 'Сайт',
				'noLink' => true,
				'items' => [
					'_admin_pages' => [
						'title' => 'Страницы',
					],
					'_admin_menu' => [
						'title' => 'Меню',
					],
					'_admin_settings' => [
						'title' => 'Настройки',
					],
				],
			],
		];
	}

	protected function getTemplateParameters(array $parameters = [])
	{
		$currentUser = $this->app[UserService::class]->getCurrentEditor();

		return $parameters + [
			'alerts' => $this->getAlertsService()->getAlerts(),
			'currentUser' => $currentUser,
			'adminMenu' => self::getMenu(),
		];
	}

} 