<?php

namespace app\common\dto;

/**
 * Interface DataGetterInterface
 * @package app\common\dto
 */
interface DataGetterInterface
{
    /**
     * @param bool $asArray
     * @return array
     */
    public function getData(bool $asArray = true) : array;
}