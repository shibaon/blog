<?php

namespace AdminBundle;

use Svi\HttpBundle\BundleTrait;
use Svi\HttpBundle\Service\HttpService;
use UserBundle\Service\UserService;
use Svi\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Bundle extends \Svi\Service\BundlesService\Bundle
{
    use BundleTrait;

	function __construct(Application $app)
	{
		parent::__construct($app);

		if (!$app->isConsole()) {
            $app[HttpService::class]->before(function(Request $request){
                if (
                    preg_match('/^\\/admin.*/', $request->getRequestUri()) &&
                    !$this->getApp()[UserService::class]->getCurrentAdmin()
                ) {
                    return new RedirectResponse($this->getRoutingService()->getUrl('_login'));
                }
            });
        }
	}

	public function getRoutes()
	{
		return [
			'FileUpload' => [
				'/admin/56eb28693ab23b9d53bd0792ad47ca8c:image',
			],
			'Front' => [
				'_admin' => '/admin:index',
			],
			'Settings' => [
				'_admin_settings' => '/admin/settings:index',
				'_admin_settings_edit' => '/admin/settings/edit/{id}:edit'
			],
		];
	}

} 