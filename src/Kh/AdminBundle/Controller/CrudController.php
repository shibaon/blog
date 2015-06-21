<?php

namespace Kh\AdminBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

abstract class CrudController extends \Sv\CrudBundle\Controller\CrudController
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
	$currentUser = $this->c->getUserManager()->getCurrentEditor();

		return parent::getTemplateParameters($parameters) + [
			'alerts' => $this->c->getAlertsManager()->getAlerts(),
			'currentUser' => $this->c->getUserManager()->getCurrentAdmin(),
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