<?php

namespace BaseBundle\Controller;

use BaseBundle\Service\SettingsService;
use ContentBundle\Service\CategoryService;
use PromoBundle\Service\MenuService;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Service\UserService;

class Controller extends \Svi\HttpBundle\Controller\Controller
{

	protected function getTemplateParameters(array $parameters = [])
	{
	    /** @var SettingsService $settings */
		$settings = $this->app[SettingsService::class];

		return $parameters + [
			'sitename' => $settings->get('sitename'),
			'siteurl' => $this->app->getConfigService()->getParameter('siteurl'),
			'sitedescription' => $settings->get('sitedescription'),
			'currentUser' => $this->app[UserService::class]->getCurrentUser(),
			'currentAdmin' => $this->app[UserService::class]->getCurrentAdmin(),
			'alerts' => $this->getAlertsService()->getAlerts(),
			'menu' => $this->app[MenuService::class]->getMenuTree(),
			'soc' => [
				'twitter' => $settings->get('soc.twitter'),
				'vk' => $settings->get('soc.vk'),
				'webmaster' => $settings->get('webmaster'),
			],
			'header' => array(
				'title' => $settings->get('sitename'),
				'motto' => $settings->get('motto'),
				'categories' => $this->app[CategoryService::class]->getCategories(),
			),
			'footer' => [
				'copyright' => $settings->get('copyright'),
				'counters' => $settings->get('counters'),
			],
			'counters' => $settings->get('counters'),
		];
	}

	/**
	 * @return \UserBundle\Entity\User|null
	 */
	protected function getCurrentUser()
	{
		return $this->app[UserService::class]->getCurrentUser();
	}

	/**
	 * @return \UserBundle\Entity\User|null
	 */
	protected function getCurrentAdmin()
	{
		return $this->app[UserService::class]->getCurrentAdmin();
	}

	protected function json(array $data = [])
    {
        return new JsonResponse($data);
    }

    protected function jsonError($message = null, array $data = [])
    {
        return $this->json(array_merge([
            'error' => true,
        ], $data));
    }

    protected function jsonSuccess(array $data = [])
    {
        return $this->json(array_merge([
            'error' => false,
        ], $data));
    }

    /**
     * @return SettingsService
     */
    protected function getSettingsService()
    {
        return $this->app[SettingsService::class];
    }

} 