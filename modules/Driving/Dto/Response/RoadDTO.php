<?php

namespace app\modules\Driving\Dto\Response;

use app\common\collection\CollectionTemplate;
use app\common\dto\BaseDTO;

/**
 * Class RoadDTO
 * @package app\modules\Driving\Dto\Response
 *
 * @property $len
 * @property $startLocation
 * @property CollectionTemplate $lanes
 */
class RoadDTO extends BaseDTO
{
    protected $attributeNames = [
        'len',
        'startLocation',
        'lanes',
    ];
}