<?php

namespace PromoBundle\Service;

use PromoBundle\BundleTrait;
use PromoBundle\Entity\Page;
use PromoBundle\Manager\PageManager;
use Svi\AppContainer;

class PageService extends AppContainer
{
    use BundleTrait;

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
		return $this->getPageManager();
	}

} 