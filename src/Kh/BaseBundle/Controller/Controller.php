<?php

namespace Kh\BaseBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

class Controller extends \Svi\Base\Controller\Controller
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
		return $parameters + [
			'sitename' => $this->c->getSettingsService()->get('sitename'),
			'siteurl' => $this->getParameter('siteurl'),
			'sitedescription' => $this->c->getSettingsService()->get('sitedescription'),
			'currentUser' => $this->c->getUserService()->getCurrentUser(),
			'currentAdmin' => $this->c->getUserService()->getCurrentAdmin(),
			'alerts' => $this->c->getAlertsService()->getAlerts(),
			'menu' => $this->c->getMenuService()->getMenuTree(),
			'soc' => [
				'twitter' => $this->c->getSettingsService()->get('soc.twitter'),
				'vk' => $this->c->getSettingsService()->get('soc.vk'),
				'webmaster' => $this->c->getSettingsService()->get('webmaster'),
			],
			'header' => array(
				'title' => $this->c->getSettingsService()->get('sitename'),
				'motto' => $this->c->getSettingsService()->get('motto'),
				'categories' => $this->c->getCategoryService()->getCategories(),
			),
			'footer' => [
				'copyright' => $this->c->getSettingsService()->get('copyright'),
				'counters' => $this->c->getSettingsService()->get('counters'),
			],
			'counters' => $this->c->getSettingsService()->get('counters'),
		];
	}

} 