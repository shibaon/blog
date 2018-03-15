<?php

namespace MailBundle;

use MailBundle\Service\MailService;

class Bundle extends \Svi\Service\BundlesService\Bundle
{

	protected function getServices()
	{
		return [
			MailService::class,
		];
	}

	/**
	 * @return MailService
	 */
	public function getMailService()
	{
		return $this->getApp()->get(MailService::class);
	}

} 