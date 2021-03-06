<?php

namespace BaseBundle\Service;

use BaseBundle\Entity\Setting;
use BaseBundle\Manager\SettingManager;
use Svi\AppContainer;

class SettingsService extends AppContainer
{
    private $allSettings;

    public function getSettingsKeys()
    {
        return array_keys($this->app->getConfigService()->get('settings'));
    }

    public function getSettingName($key)
    {
        $settings = $this->app->getConfigService()->get('settings');
        return is_string($settings[$key]) ? $settings[$key] : $settings[$key]['title'];
    }

    public function getSettingType($key)
    {
        $settings = $this->app->getConfigService()->get('settings');
        $type = is_array($settings[$key]) && isset($settings[$key]['type']) ? $settings[$key]['type'] : 'textarea';
        return $type;
    }

    public function updateDatabase()
    {
        $exists = $this->getManager()->findBy();
        foreach (array_keys($this->app->getConfigService()->get('settings')) as $key) {
            $inDb = null;
            foreach ($exists as $e) {
                if (strtolower($e->getKey()) == strtolower($key)) {
                    $inDb = $e;
                    break;
                }
            }
            if (!$inDb) {
                $inDb = new Setting();
                $inDb->setKey($key);
                $this->getManager()->save($inDb);
            }
        }
    }

    public function get($key, $default = null)
    {
        $key = strtolower($key);
        $this->fetchAllSettings();
        return isset($this->allSettings[$key]) ? $this->allSettings[strtolower($key)] : $default;
    }

    public function set($key, $value)
    {
        $setting = $this->getSetting($key);
        if ($setting) {
            $setting->setValue($value);
        } else {
            $setting = new Setting();
            $setting->setKey($key);
            $setting->setValue($value);
        }
        $this->getManager()->save($setting);
        $this->allSettings[strtolower($key)] = $value;
    }

    protected function fetchAllSettings()
    {
        if (!isset($this->allSettings)) {
            $this->allSettings = array();
            foreach ($this->getManager()->getConnection()->createQueryBuilder()->select('*')->from('setting', '')->execute()->fetchAll() as $v) {
                $this->allSettings[strtolower($v['skey'])] = $v['value'];
            }
        }
    }

    /**
     * @param $key
     * @return Setting
     */
    protected function getSetting($key)
    {
        return $this->getManager()->fetchOne($this->createQB()->where('skey = :key')->setParameter('key', $key));
    }

    /**
     * @return SettingManager
     */
    protected function getManager()
    {
        return $this->app[SettingManager::class];
    }

}