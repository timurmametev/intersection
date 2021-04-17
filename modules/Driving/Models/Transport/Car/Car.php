<?php

namespace app\modules\Driving\Models\Transport\Car;

use app\modules\Driving\Models\Characteristic\TransportSpeed;
use app\modules\Driving\Models\Transport\TransportInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Car
 * @package app\modules\Driving\Models\Transport\Car
 */
class Car implements TransportInterface
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @var TransportSpeed
     */
    private $minSpeed;

    /**
     * @var TransportSpeed
     */
    private $maxSpeed;

    /**
     * Car constructor.
     *
     * @param UuidInterface $uuid
     * @param TransportSpeed $minSpeed
     * @param TransportSpeed $maxSpeed
     */
    public function __construct(
        UuidInterface $uuid,
        TransportSpeed $minSpeed,
        TransportSpeed $maxSpeed
    )
    {
        $this->uuid     = $uuid;
        $this->minSpeed = $minSpeed;
        $this->maxSpeed = $maxSpeed;
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
    public function getMaxSpeed(): int
    {
        return $this->maxSpeed->getValue();
    }

    /**
     * @return int
     */
    public function getMinSpeed(): int
    {
        return $this->minSpeed->getValue();
    }
}