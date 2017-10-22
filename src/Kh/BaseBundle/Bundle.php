<?php

namespace Kh\BaseBundle;

use Kh\PromoBundle\Controller\PageController;
use Svi\Application;
use Svi\Exception\NotFoundHttpException;

class Bundle extends \Svi\Service\BundlesService\Bundle
{

	function __construct(Application $app)
	{
		date_default_timezone_set('Asia/Krasnoyarsk');

		$app->error(function(NotFoundHttpException $e, $code) use ($app) {
			$controller = new PageController($app);

			return $controller->notFoundAction();
		});
	}


} 