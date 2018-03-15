<?php

namespace PromoBundle\Service;

use BaseBundle\ContainerAware;
use PromoBundle\BundleTrait;
use Svi\AppContainer;
use Svi\HttpBundle\Service\HttpService;

class MenuService extends AppContainer
{
    use BundleTrait;

	public function getMenuTree()
	{
		return $this->formatTree($this->getMenuManager()->findBy([], ['weight' => 'asc']));
	}

	protected function formatTree($menuItems)
	{
		$items = array();
		foreach ($menuItems as $i) {
			$items[$i->getId()] = array(
				'id' => $i->getId(),
				'url' => $i->getUrl(),
				'title' => $i->getTitle(),
				'children' => array(),
				'parent' => $i->getParentId(),
				'current' => $this->isUrlCurrent($i->getUrl()),
			);
		}

		foreach ($items as $key => &$value) {
			if ($value['parent']) {
				$items[$value['parent']]['children'][$key] = &$value;
				if ($value['current']) {
					$items[$value['parent']]['current'] = true;
				}
			}
		}
		unset($value);

		foreach ($items as $key => &$value) {
			if ($value['parent']) {
				unset($items[$key]);
			}
		}

		return $items;
	}

	protected function isUrlCurrent($url)
	{
		if (!$url) {
			return false;
		}

		$request = $this->app[HttpService::class]->getRequest()->getRequestUri();

		if ($url == '/') {
			if ($request == '/') {
				return true;
			}
		} else if (strpos($request, $url) === 0) {
			return true;
		}

		return false;
	}

} 