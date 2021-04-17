<?php

namespace app\modules\Driving\Dto\Characteristic;

use app\common\dto\BaseDTO;

/**
 * Class LocationDTO
 * @package app\modules\Driving\Dto\Characteristic
 * 
 * @property integer $x
 * @property integer $y
 */
class LocationDTO extends BaseDTO
{
    protected $attributeNames = [
        'x',
        'y'
    ];
}