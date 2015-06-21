<?php

namespace Kh\BaseBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

class Controller extends \Sv\BaseBundle\Controller\Controller
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
			'sitename' => $this->c->getSettingsManager()->get('sitename'),
			'siteurl' => $this->getParameter('siteurl'),
			'sitedescription' => $this->c->getSettingsManager()->get('sitedescription'),
			'currentUser' => $this->c->getUserManager()->getCurrentUser(),
			'currentAdmin' => $this->c->getUserManager()->getCurrentAdmin(),
			'alerts' => $this->c->getAlertsManager()->getAlerts(),
			'menu' => $this->c->getMenuManager()->getMenuTree(),
			'soc' => [
				'twitter' => $this->c->getSettingsManager()->get('soc.twitter'),
				'vk' => $this->c->getSettingsManager()->get('soc.vk'),
				'webmaster' => $this->c->getSettingsManager()->get('webmaster'),
			],
			'header' => array(
				'title' => $this->c->getSettingsManager()->get('sitename'),
				'motto' => $this->c->getSettingsManager()->get('motto'),
				'categories' => $this->c->getCategoryManager()->getCategories(),
			),
			'footer' => [
				'copyright' => $this->c->getSettingsManager()->get('copyright'),
				'counters' => $this->c->getSettingsManager()->get('counters'),
			],
			'counters' => $this->c->getSettingsManager()->get('counters'),
		];
	}

} 