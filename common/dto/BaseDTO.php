<?php

namespace app\common\dto;

/**
 * Class BaseDTO
 * @package app\common\dto
 */
class BaseDTO implements DTOInterface
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $attributeNames = [];

    /**
     * BaseDTO constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            if (in_array($name, $this->attributeNames)) {
                $this->attributes[$name] = $value;
            }
        }
        $this->processData();
    }

    /**
     * @param bool $asArray
     * @return array
     */
    public function getData(bool $asArray = true): array
    {
        $result = [];
        foreach ($this->attributeNames as $name) {
            if (array_key_exists($name, $this->attributes)) {
                $result[$name] = $this->attributes[$name];
            } else {
                $result[$name] = null;
            }
            if (($result[$name] instanceof DataGetterInterface) && $asArray) {
                $result[$name] = $result[$name]->getData();
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return $this->getData();
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (in_array($name, $this->attributeNames)) {
            return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : null;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->attributeNames)) {
            $this->attributes[$name] = $value;
        }
    }

    public function processData() {}
}