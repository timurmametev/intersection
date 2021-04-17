<?php

namespace app\common\collection;

use app\common\dto\DataGetterInterface;

/**
 * Interface CollectionInterface
 * @package app\common\collection
 */
interface CollectionInterface extends DataGetterInterface
{
    public function setData(array $data);
    public function addData(array $data, bool $multiple = false);
}