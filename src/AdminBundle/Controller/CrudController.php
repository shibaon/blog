<?php

namespace AdminBundle\Controller;

use UserBundle\Entity\User;
use UserBundle\Service\UserService;

abstract class CrudController extends \Svi\CrudBundle\Controller\CrudController
{

	protected function getTemplateParameters(array $parameters = [])
	{
		return parent::getTemplateParameters($parameters) + [
			'alerts' => $this->getAlertsService()->getAlerts(),
			'currentUser' => $this->app[UserService::class]->getCurrentAdmin(),
			'adminMenu' => Controller::getMenu(),
		];
	}

	protected function getBaseTemplate()
	{
		return 'AdminBundle/Views/base.twig';
	}

	protected function getItemsPerPage()
	{
		return 50;
	}

    /**
     * @return User|null
     */
	protected function getCurrentUser()
    {
        return $this->app[UserService::class]->getCurrentUser();
    }

} 