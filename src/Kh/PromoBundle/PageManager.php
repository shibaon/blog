<?php

namespace Kh\PromoBundle;

use Kh\BaseBundle\ContainerAware;
use Kh\PromoBundle\Entity\Page;

class PageManager extends ContainerAware
{

	/**
	 * @param $url
	 * @return Page
	 */
	public function getPageByUrl($url)
	{
		return Page::findOneByUri($url);
	}

} 