<?php

namespace Kh\AdminBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

abstract class Controller extends \Kh\BaseBundle\Controller\Controller
{
	/**
	 * @var Container
	 */
	protected $c;

	function __construct(Application $app)
	{
		$this->c = Container::getInstance($app);
	}

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
		$currentUser = $this->c->getUserBundle()->getUserService()->getCurrentEditor();

		return $parameters + [
			'alerts' => $this->c->getSviBaseBundle()->getAlertsService()->getAlerts(),
			'currentUser' => $currentUser,
			'adminMenu' => self::getMenu(),
		];
	}

} 