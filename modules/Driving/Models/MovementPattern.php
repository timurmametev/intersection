<?php

namespace app\modules\Driving\Models;

use app\modules\Driving\Models\Road\Road;
use app\modules\Driving\Models\Transport\TransportState;

class MovementPattern
{
    public const START_POSITION = 0;

    /**
     * Частота появления транспорта на полосе в секунду
     */
    public const SPAWN_FREQUENCY = 5;

    /**
     * @var Road
     */
    private $road;

    /**
     * @var TransportState[]
     */
    private $transportStates;

    /**
     * MovementPattern constructor.
     *
     * @param Road $road
     */
    public function __construct(Road $road)
    {
        $this->road = $road;
    }

    /**
     * @param TransportState $state
     */
    public function addTransport(TransportState $state): void
    {
        $this->transportStates[$state->getTransportUuid()] = $state;
    }

    /**
     * @param TransportState $state
     */
    public function removeTransport(TransportState $state): void
    {
        if (array_key_exists($state->getTransportUuid(), $this->transportStates)) {
            unset($this->transportStates[$state->getTransportUuid()]);
        }
    }

    /**
     * @return Road
     */
    public function getRoad(): Road
    {
        return $this->road;
    }

    /**
     * @return TransportState[]
     */
    public function getTransportStates(): array
    {
        return $this->transportStates;
    }
}