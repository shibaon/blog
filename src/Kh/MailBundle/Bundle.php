<?php

namespace Kh\MailBundle;

class Bundle extends \Svi\Bundle
{

	protected function getServices()
	{
		return [
			'service.mail' => 'Service\MailService',
		];
	}

} 