<?php

namespace Kh\PromoBundle\Service;

use Kh\BaseBundle\ContainerAware;
use Kh\PromoBundle\Entity\Page;
use Kh\PromoBundle\Manager\PageManager;

class PageService extends ContainerAware
{

	/**
	 * @param $url
	 * @return Page
	 */
	public function getPageByUrl($url)
	{
		return $this->getManager()->findOneByUri($url);
	}

	/**
	 * @return PageManager
	 */
	protected function getManager()
	{
		return $this->c->getPromoBundle()->getPageManager();
	}

} 