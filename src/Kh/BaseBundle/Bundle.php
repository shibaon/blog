<?php

namespace Kh\BaseBundle;

use Kh\PromoBundle\Controller\PageController;
use Svi\Application;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Bundle extends \Svi\Bundle
{

	function __construct(Application $app)
	{
		date_default_timezone_set('Asia/Krasnoyarsk');

		$app->getSilex()->error(function(NotFoundHttpException $e, $code) use ($app) {
			$controller = new PageController($app);

			return $controller->notFoundAction();
		});
	}


} 