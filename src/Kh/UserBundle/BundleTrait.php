<?php

namespace Kh\UserBundle;

use Kh\UserBundle\Manager\UserManager;
use Kh\UserBundle\Service\AuthorizationService;
use Kh\UserBundle\Service\UserService;

trait BundleTrait
{
    use \Svi\Service\BundlesService\BundleTrait;

    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->get(UserService::class);
    }

    /**
     * @return AuthorizationService
     */
    public function getAuthorizationService()
    {
        return $this->get(AuthorizationService::class);
    }

    /**
     * @return UserManager
     */
    public function getUserManager()
    {
        return $this->get(UserManager::class);
    }
}