<?php

namespace app\modules\Driving\Dto\Response;

use app\common\dto\BaseDTO;

/**
 * Class TransportDTO
 * @package app\modules\Driving\Dto\Response
 *
 * @property $uuid
 * @property $speed
 * @property $location
 * @property $laneUuid
 */
class TransportDTO extends BaseDTO
{
    protected $attributeNames = [
        'uuid',
        'speed',
        'location',
        'laneUuid'
    ];
}