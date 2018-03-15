<?php

namespace ContentBundle;

use ContentBundle\Manager\CategoryManager;
use ContentBundle\Manager\PostCategoryManager;
use ContentBundle\Manager\PostManager;
use ContentBundle\Service\CategoryService;
use ContentBundle\Service\PostService;

trait BundleTrait
{
    /**
     * @return PostService
     */
    public function getPostService()
    {
        return $this->app[PostService::class];
    }

    /**
     * @return CategoryService
     */
    public function getCategoryService()
    {
        return $this->app[CategoryService::class];
    }

    /**
     * @return CategoryManager
     */
    public function getCategoryManager()
    {
        return $this->app[CategoryManager::class];
    }

    /**
     * @return PostCategoryManager
     */
    public function getPostCategoryManager()
    {
        return $this->app[PostCategoryManager::class];
    }

    /**
     * @return PostManager
     */
    public function getPostManager()
    {
        return $this->app[PostManager::class];
    }
}