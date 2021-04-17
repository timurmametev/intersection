<?php

namespace app\modules\Driving\Models\Transport;

use app\modules\Driving\Dto\Characteristic\LocationDTO;
use app\modules\Driving\Models\Characteristic\LaneDirection;
use app\modules\Driving\Models\Characteristic\Location;
use app\modules\Driving\Models\Characteristic\TransportSpeed;
use app\modules\Driving\Models\Road\LaneState;

/**
 * Class TransportState
 * @package app\modules\Driving\Models\Transport
 */
class TransportState
{
    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var TransportSpeed
     */
    private $speed;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var LaneState
     */
    private $lane;

    /**
     * TransportState constructor.
     *
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param TransportSpeed $transportSpeed
     */
    public function setSpeed(TransportSpeed $transportSpeed): void
    {
        $this->speed = $transportSpeed;
    }

    /**
     * @param Location $coordinate
     */
    public function setLocation(Location $coordinate): void
    {
        $this->location = $coordinate;
    }

    /**
     * @param LaneState $lane
     */
    public function setLane(LaneState $lane): void
    {
        $this->lane = $lane;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed->getValue();
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @return LaneState
     */
    public function getLane(): LaneState
    {
        return $this->lane;
    }

    /**
     * @return string
     */
    public function getTransportUuid(): string
    {
        return $this->transport->getUuid();
    }

    /**
     * @param int $deltaTime
     */
    public function move(int $deltaTime): void
    {
        $location = $this->location->getLocation();

        $location->x = $deltaTime * $this->speed
            * LaneDirection::getDirectionMultiplier($this->lane->getDirection());

        $this->location->setLocation($location);
    }
}