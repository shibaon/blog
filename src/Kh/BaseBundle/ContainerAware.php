<?php

namespace Kh\BaseBundle;

use Svi\Application;

class ContainerAware extends \Sv\BaseBundle\ContainerAware
{
	/**
	 * @var Container
	 */
	protected $c;

	function __construct(Application $app)
	{
		$this->c = Container::getInstance($app);
	}

} 