<?php

namespace Kh\ContentBundle;

use Kh\ContentBundle\Manager\CategoryManager;
use Kh\ContentBundle\Manager\PostCategoryManager;
use Kh\ContentBundle\Manager\PostManager;
use Kh\ContentBundle\Service\CategoryService;
use Kh\ContentBundle\Service\PostService;

trait BundleTrait
{
    use \Svi\Service\BundlesService\BundleTrait;

    /**
     * @return PostService
     */
    public function getPostService()
    {
        return $this->get(PostService::class);
    }

    /**
     * @return CategoryService
     */
    public function getCategoryService()
    {
        return $this->get(CategoryService::class);
    }

    /**
     * @return CategoryManager
     */
    public function getCategoryManager()
    {
        return $this->get(CategoryManager::class);
    }

    /**
     * @return PostCategoryManager
     */
    public function getPostCategoryManager()
    {
        return $this->get(PostCategoryManager::class);
    }

    /**
     * @return PostManager
     */
    public function getPostManager()
    {
        return $this->get(PostManager::class);
    }
}