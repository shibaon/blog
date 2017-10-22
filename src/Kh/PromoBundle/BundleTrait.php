<?php

namespace Kh\PromoBundle;

use Kh\PromoBundle\Manager\MenuManager;
use Kh\PromoBundle\Manager\PageManager;
use Kh\PromoBundle\Service\MenuService;
use Kh\PromoBundle\Service\PageService;

trait BundleTrait
{
    use \Svi\Service\BundlesService\BundleTrait;

    /**
     * @return MenuService
     */
    public function getMenuService()
    {
        return $this->get(MenuService::class);
    }

    /**
     * @return PageService
     */
    public function getPageService()
    {
        return $this->get(PageService::class);
    }

    /**
     * @return MenuManager
     */
    public function getMenuManager()
    {
        return $this->get(MenuManager::class);
    }

    /**
     * @return PageManager
     */
    public function getPageManager()
    {
        return $this->get(PageManager::class);
    }
}