<?php

namespace app\common\dto;

/**
 * Interface DTOInterface
 * @package app\common\dto
 */
Interface DTOInterface extends DataGetterInterface
{
    public function __construct(array $attributes = []);
    public function processData();
}