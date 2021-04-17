<?php

namespace app\modules\Driving\Models\Road;

use app\modules\Driving\Models\Characteristic\LaneIntensity;
use app\modules\Driving\Models\Characteristic\TransportSpeed;
use Ramsey\Uuid\UuidInterface;

class Lane
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @var integer
     */
    public $intensity;

    /**
     * @var integer
     */
    public $maxSpeed;

    /**
     * Lane constructor.
     *
     * @param UuidInterface $uuid
     * @param LaneIntensity $intensity
     * @param TransportSpeed $maxSpeed
     */
    public function __construct(
        UuidInterface $uuid,
        LaneIntensity $intensity,
        TransportSpeed $maxSpeed
    )
    {
        $this->uuid      = $uuid;
        $this->intensity = $intensity;
        $this->maxSpeed  = $maxSpeed;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @return int
     */
    public function getIntensity(): int
    {
        return $this->intensity->getValue();
    }

    /**
     * @return int
     */
    public function getMaxSpeed(): int
    {
        return $this->maxSpeed->getValue();
    }
}