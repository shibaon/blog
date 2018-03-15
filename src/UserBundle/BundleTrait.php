<?php

namespace UserBundle;

use UserBundle\Manager\UserManager;
use UserBundle\Service\AuthorizationService;
use UserBundle\Service\UserService;

trait BundleTrait
{
    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->app[UserService::class];
    }

    /**
     * @return AuthorizationService
     */
    public function getAuthorizationService()
    {
        return $this->app[AuthorizationService::class];
    }

    /**
     * @return UserManager
     */
    public function getUserManager()
    {
        return $this->app[UserManager::class];
    }
}