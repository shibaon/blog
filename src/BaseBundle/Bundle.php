<?php

namespace BaseBundle;

use BaseBundle\Manager\SettingManager;
use BaseBundle\Service\SettingsService;
use PromoBundle\Controller\PageController;
use Svi\Application;
use Svi\HttpBundle\Exception\NotFoundHttpException;

class Bundle extends \Svi\Service\BundlesService\Bundle
{

	function __construct(Application $app)
	{
	    parent::__construct($app);

		date_default_timezone_set('Asia/Krasnoyarsk');

		$app->error(function(NotFoundHttpException $e, $code) use ($app) {
			$controller = new PageController($app);

			return $controller->notFoundAction();
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