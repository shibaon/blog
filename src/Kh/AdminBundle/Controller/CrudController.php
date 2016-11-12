<?php

namespace Kh\AdminBundle\Controller;

use Kh\BaseBundle\Container;
use Svi\Application;

abstract class CrudController extends \Svi\Crud\Controller\CrudController
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
		$currentUser = $this->c->getUserService()->getCurrentEditor();

		return parent::getTemplateParameters($parameters) + [
			'alerts' => $this->c->getAlertsService()->getAlerts(),
			'currentUser' => $this->c->getUserService()->getCurrentAdmin(),
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