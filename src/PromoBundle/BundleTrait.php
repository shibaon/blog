<?php

namespace PromoBundle;

use PromoBundle\Manager\MenuManager;
use PromoBundle\Manager\PageManager;
use PromoBundle\Service\MenuService;
use PromoBundle\Service\PageService;

trait BundleTrait
{
    /**
     * @return MenuService
     */
    public function getMenuService()
    {
        return $this->app[MenuService::class];
    }

    /**
     * @return PageService
     */
    public function getPageService()
    {
        return $this->app[PageService::class];
    }

    /**
     * @return MenuManager
     */
    public function getMenuManager()
    {
        return $this->app[MenuManager::class];
    }

    /**
     * @return PageManager
     */
    public function getPageManager()
    {
        return $this->app[PageManager::class];
    }
}