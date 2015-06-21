<?php

namespace Kh\AdminBundle;

use Kh\UserBundle\Entity\User;
use Svi\Application;
use Symfony\Component\HttpFoundation\Request;

class Bundle extends \Svi\Bundle
{

	public function getRoutes()
	{
		return [
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