<?php

namespace BaseBundle\Manager;

use BaseBundle\Entity\Setting;
use Svi\OrmBundle\Manager;

class SettingManager extends Manager
{

    public function getDbFieldsDefinition()
    {
        return [
            'id' => ['id', 'integer', 'id'],
            'key' => ['skey', 'string', 'length' => 64, 'unique'],
            'value' => ['value', 'text', 'null'],
        ];
    }

    public function getTableName()
    {
        return 'setting';
    }

    public function getEntityClassName()
    {
        return Setting::class;
    }

}