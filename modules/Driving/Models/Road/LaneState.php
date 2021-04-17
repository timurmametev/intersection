<?php

namespace app\modules\Driving\Models\Road;


use app\modules\Driving\Models\Characteristic\Coordinate;
use app\modules\Driving\Models\Characteristic\LaneDirection;
use app\modules\Driving\Models\Characteristic\LaneSerialNumber;
use app\modules\Driving\Models\Characteristic\LaneWidth;
use app\modules\Driving\Models\Characteristic\Location;
use Yii;

/**
 * Class LaneState
 * @package app\modules\Driving\Models\Road
 */
class LaneState
{
    /**
     * @var Lane
     */
    private $lane;

    /**
     * @var LaneSerialNumber
     */
    private $number;

    /**
     * @var LaneDirection
     */
    private $direction;

    /**
     * @var LaneWidth
     */
    private $width;

    /**
     * LaneState constructor.
     *
     * @param Lane $lane
     */
    public function __construct(Lane $lane)
    {
        $this->lane = $lane;
    }

    /**
     * @param LaneSerialNumber $number
     */
    public function setNumber(LaneSerialNumber $number): void
    {
        $this->number = $number;
    }

    /**
     * @param LaneDirection $direction
     */
    public function setDirection(LaneDirection $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @param LaneWidth $width
     */
    public function setWidth(LaneWidth $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number->getValue();
    }

    /**
     * @return string
     */
    public function getLaneUuid(): string
    {
        return $this->lane->getUuid();
    }

    /**
     * @return int
     */
    public function getDirection(): int
    {
        return $this->direction->getValue();
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width->getValue();
    }

    /**
     * @param Road $road
     * @return Location
     */
    public function getStartLocation(Road $road): Location
    {
        $roadStartLocation = $road->getStartLocation();

        $x = $roadStartLocation->x +
            ((1 - LaneDirection::getDirectionMultiplier($this->getDirection())) / 2) * $road->getLength();

        $y = $roadStartLocation->y +
            $this->getWidth() * ($this->getNumber() + 1) * LaneDirection::getDirectionMultiplier($this->getDirection());

        return new Location(
            new Coordinate($x),
            new Coordinate($y)
        );
    }

    /**
     * @param Road $road
     * @return Location
     */
    public function getEndLocation(Road $road): Location
    {
        $laneStartLocation = $this->getStartLocation($road);

        $x = $laneStartLocation->getLocation()->x +
            $road->getLength() * LaneDirection::getDirectionMultiplier($this->getDirection());

        return new Location(
            new Coordinate($x),
            new Coordinate($laneStartLocation->getLocation()->y)
        );
    }

    /**
     * @param Location $location
     * @param Road $road
     * @return bool
     */
    public function checkLocationIsOnLane(Location $location, Road $road): bool
    {
        $laneStartLocation = $this->getStartLocation($road);
        $laneEndLocation = $this->getEndLocation($road);

        return (
                (
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $laneStartLocation->getLocation()->x <=
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $location->getLocation()->x
                ) && (
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $laneEndLocation->getLocation()->x >=
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $location->getLocation()->x
                )) && ((
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $laneStartLocation->getLocation()->y <=
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $location->getLocation()->y
                ) && (
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $laneEndLocation->getLocation()->y >=
                    LaneDirection::getDirectionMultiplier($this->getDirection()) * $location->getLocation()->y
                )
            );
    }
}