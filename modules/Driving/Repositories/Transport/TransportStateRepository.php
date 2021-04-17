<?php

namespace app\modules\Driving\Repositories\Transport;


use app\modules\Driving\Models\Characteristic\TransportSpeed;
use app\modules\Driving\Models\Road\LaneState;
use app\modules\Driving\Models\Road\Road;
use app\modules\Driving\Models\Transport\TransportState;

class TransportStateRepository
{
    /**
     * @param TransportState $transportState
     * @param Road $road
     * @param TransportSpeed $speed
     * @param LaneState $laneState
     */
    public static function fillProperties(
        TransportState &$transportState,
        Road $road,
        TransportSpeed $speed,
        LaneState $laneState
    ) {
        $transportState->setSpeed($speed);
        $transportState->setLane($laneState);

        $location = $laneState->getStartLocation($road);

        $transportState->setLocation($location);
    }
}