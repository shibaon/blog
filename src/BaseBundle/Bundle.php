<?php

namespace BaseBundle;

use BaseBundle\Manager\SettingManager;
use BaseBundle\Service\SettingsService;
use PromoBundle\Controller\PageController;
use Svi\Application;
use Svi\HttpBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class Bundle extends \Svi\Service\BundlesService\Bundle
{

	function __construct(Application $app)
	{
	    parent::__construct($app);

		date_default_timezone_set('Europe/Moscow');

		$app->error(function(NotFoundHttpException $e, $code) use ($app) {
			$controller = new PageController($app);

			return new Response($controller->notFoundAction(), 404);
		});
	}

	protected function getServices()
    {
        return [
            SettingManager::class,
            SettingsService::class,
        ];
    }

}