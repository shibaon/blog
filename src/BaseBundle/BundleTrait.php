<?php

namespace BaseBundle;

use BaseBundle\Manager\SettingManager;
use BaseBundle\Service\SettingsService;

trait BundleTrait
{
    /**
     * @return SettingManager
     */
    public function getSettingManager()
    {
        return $this->app[SettingManager::class];
    }

    /**
     * @return SettingsService
     */
    public function getSettingsService()
    {
        return $this->app[SettingsService::class];
    }

}