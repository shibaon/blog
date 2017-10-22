<?php

namespace Kh\BaseBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

class Controller extends \Svi\BaseBundle\Controller\Controller
{
	/**
	 * @var Container
	 */
	protected $c;

	function __construct(Application $app)
	{
		$this->c = Container::getInstance($app);
	}

	protected function getTemplateParameters(array $parameters = [])
	{
		$settings = $this->c->getSviBaseBundle()->getSettingsService();
		$userService = $this->c->getUserBundle()->getUserService();

		return $parameters + [
			'sitename' => $settings->get('sitename'),
			'siteurl' => $this->getParameter('siteurl'),
			'sitedescription' => $settings->get('sitedescription'),
			'currentUser' => $userService->getCurrentUser(),
			'currentAdmin' => $userService->getCurrentAdmin(),
			'alerts' => $this->c->getSviBaseBundle()->getAlertsService()->getAlerts(),
			'menu' => $this->c->getPromoBundle()->getMenuService()->getMenuTree(),
			'soc' => [
				'twitter' => $settings->get('soc.twitter'),
				'vk' => $settings->get('soc.vk'),
				'webmaster' => $settings->get('webmaster'),
			],
			'header' => array(
				'title' => $settings->get('sitename'),
				'motto' => $settings->get('motto'),
				'categories' => $this->c->getContentBundle()->getCategoryService()->getCategories(),
			),
			'footer' => [
				'copyright' => $settings->get('copyright'),
				'counters' => $settings->get('counters'),
			],
			'counters' => $settings->get('counters'),
		];
	}

	/**
	 * @return \Kh\UserBundle\Entity\User|null
	 */
	protected function getCurrentUser()
	{
		return $this->c->getUserBundle()->getUserService()->getCurrentUser();
	}

	/**
	 * @return \Kh\UserBundle\Entity\User|null
	 */
	protected function getCurrentAdmin()
	{
		return $this->c->getUserBundle()->getUserService()->getCurrentAdmin();
	}

} 