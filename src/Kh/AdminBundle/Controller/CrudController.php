<?php

namespace Kh\AdminBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

abstract class CrudController extends \Svi\CrudBundle\Controller\CrudController
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
		return parent::getTemplateParameters($parameters) + [
			'alerts' => $this->c->getSviBaseBundle()->getAlertsService()->getAlerts(),
			'currentUser' => $this->c->getUserBundle()->getUserService()->getCurrentAdmin(),
			'adminMenu' => Controller::getMenu(),
		];
	}

	protected function getBaseTemplate()
	{
		return 'Kh/AdminBundle/Views/base.twig';
	}

	protected function getItemsPerPage()
	{
		return 50;
	}

} 