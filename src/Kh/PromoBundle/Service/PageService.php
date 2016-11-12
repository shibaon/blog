<?php

namespace Kh\PromoBundle\Service;

use Kh\BaseBundle\ContainerAware;
use Kh\PromoBundle\Entity\Page;

class PageService extends ContainerAware
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