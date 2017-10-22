<?php

namespace Svi\BaseBundle\Service;

use Svi\BaseBundle\BundleTrait;
use Svi\BaseBundle\ContainerAware;

class AlertsService extends ContainerAware
{
    use BundleTrait;

	public function addAlert($type, $text)
	{
		$alerts = $this->c->getSession()->get('alerts');
		if (!$alerts) {
			$alerts = [];
		}
		$alerts[] = ['type' => $type, 'text' => $text];

		$this->c->getSession()->set('alerts', $alerts);
	}

	public function getAlerts()
	{
		$alerts = $this->c->getSession()->get('alerts');
		$this->c->getSession()->uns('alerts');

		return $alerts;
	}

}
