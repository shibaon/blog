<?php

namespace Kh\MailBundle;

class Bundle extends \Svi\Bundle
{

	protected function getManagers()
	{
		return [
			'mail' => 'Mail',
		];
	}

} 