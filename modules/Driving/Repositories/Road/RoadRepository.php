<?php

namespace app\modules\Driving\Repositories\Road;

use app\modules\Driving\Models\Characteristic\Coordinate;
use app\modules\Driving\Models\Characteristic\Location;
use app\modules\Driving\Models\Characteristic\RoadLength;
use app\modules\Driving\Models\Characteristic\RoadPriority;
use app\modules\Driving\Models\MovementPattern;
use app\modules\Driving\Models\Road\LaneState;
use app\modules\Driving\Models\Road\Road;

class RoadRepository
{
    /**
     * @return Road
     */
    public static function generateDefaultRoad(): Road
    {
        return new Road(
            new RoadLength(RoadLength::DEFAULT_VALUE),
            new RoadPriority(RoadPriority::DEFAULT_VALUE),
            new Location(
                new Coordinate(MovementPattern::START_POSITION),
                new Coordinate(MovementPattern::START_POSITION)
            )
        );
    }

    /**
     * @param Road $road
     * @param LaneState $laneState
     */
    public static function addLine(Road &$road, LaneState $laneState): void
    {
        $road->addLane($laneState);
    }
}