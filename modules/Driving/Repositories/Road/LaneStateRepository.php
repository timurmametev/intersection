<?php

namespace app\modules\Driving\Repositories\Road;

use app\modules\Driving\Models\Characteristic\LaneDirection;
use app\modules\Driving\Models\Characteristic\LaneSerialNumber;
use app\modules\Driving\Models\Characteristic\LaneWidth;
use app\modules\Driving\Models\Road\LaneState;
use Exception;

class LaneStateRepository
{
    /**
     * @param int $laneDirection
     * @param int $laneWidth
     * @param int $laneNumber
     * @return LaneState
     * @throws Exception
     */
    public static function createLaneState(int $laneDirection, int $laneWidth, int $laneNumber): LaneState
    {
        $laneState = new LaneState(
            LaneRepository::createLane()
        );

        $laneState->setDirection(
            new LaneDirection($laneDirection)
        );

        $laneState->setNumber(
            new LaneSerialNumber($laneNumber)
        );

        $laneState->setWidth(
            new LaneWidth($laneWidth)
        );

        return $laneState;
    }
}