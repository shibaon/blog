<?php

namespace Kh\MailBundle;

use Kh\MailBundle\Service\MailService;

class Bundle extends \Svi\Bundle
{

	protected function getServices()
	{
		return [
			'service.mail' => 'Service\MailService',
		];
	}

	/**
	 * @return MailService
	 */
	public function getMailService()
	{
		return $this->getApp()->get('service.mail');
	}

} 