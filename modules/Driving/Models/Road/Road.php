<?php

namespace app\modules\Driving\Models\Road;


use app\modules\Driving\Dto\Characteristic\LocationDTO;
use app\modules\Driving\Models\Characteristic\LaneDirection;
use app\modules\Driving\Models\Characteristic\Location;
use app\modules\Driving\Models\Characteristic\RoadLength;
use app\modules\Driving\Models\Characteristic\RoadPriority;

/**
 * Class Road
 * @package app\modules\Driving\Models\Road
 */
class Road
{
    /**
     * @var RoadLength
     */
    private $length;

    /**
     * @var RoadPriority
     */
    private $priority;

    /**
     * @var LaneState[]
     */
    private $lanes;

    /**
     * @var Location
     */
    private $startLocation;

    /**
     * Road constructor.
     *
     * @param RoadLength $length
     * @param RoadPriority $priority
     * @param Location $startLocation
     */
    public function __construct(RoadLength $length, RoadPriority $priority, Location $startLocation)
    {
        $this->length = $length;
        $this->priority = $priority;
        $this->startLocation = $startLocation;
    }

    /**
     * @param LaneState $lane
     */
    public function addLane(LaneState $lane): void
    {
        $this->lanes[$lane->getLaneUuid()] = $lane;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length->getValue();
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority->getValue();
    }

    /**
     * @return LaneState[]
     */
    public function getLanes(): array
    {
        return $this->lanes;
    }

    /**
     * @return LocationDTO
     */
    public function getStartLocation(): LocationDTO
    {
        return $this->startLocation->getLocation();
    }

    /**
     * @return array
     */
    public function getForwardLanes(): array
    {
        return array_filter($this->lanes, function (LaneState $v) {
            return $v->getDirection() == LaneDirection::DIRECTION_FORWARD;
        });
    }

    /**
     * @return array
     */
    public function getBackwardLanes(): array
    {
        return array_filter($this->lanes, function (LaneState $v) {
            return $v->getDirection() == LaneDirection::DIRECTION_BACKWARD;
        });
    }
}