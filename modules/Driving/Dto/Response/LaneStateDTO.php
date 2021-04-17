<?php

namespace app\modules\Driving\Dto\Response;

use app\common\dto\BaseDTO;

/**
 * Class LaneStateDTO
 * @package app\modules\Driving\Dto\Response
 *
 * @property $uuid
 * @property $width
 * @property $direction
 * @property $startLocation
 */
class LaneStateDTO extends BaseDTO
{
    protected $attributeNames = [
        'uuid',
        'width',
        'direction',
        'startLocation'
    ];
}