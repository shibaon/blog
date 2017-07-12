<?php

namespace Kh\AdminBundle;

use Kh\UserBundle\Entity\User;
use Svi\Application;
use Symfony\Component\HttpFoundation\Request;

class Bundle extends \Svi\Bundle
{

	function __construct(Application $app)
	{
		parent::__construct($app);

		$app->getSilex()->before(function(Request $request){
			if (
				preg_match('/^\\/admin.*/', $request->getRequestUri()) &&
				!$this->getApp()->get('service.user')->getCurrentAdmin()
			) {
				return $this->getApp()->getSilex()->redirect($this->getApp()->getRouting()->getUrl('_login'));
			}
		});
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