<?php

namespace BaseBundle\Entity;

use Svi\OrmBundle\Entity;

class Setting extends Entity
{
    private $id;
    private $key;
    private $value;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }


    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    function __toString()
    {
        return (string)$this->getKey();
    }

}