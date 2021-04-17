<?php

namespace app\modules\Driving\Repositories;

use app\modules\Driving\Models\MovementPattern;
use app\modules\Driving\Models\Transport\TransportState;

/**
 * Class MovementPatternRepository
 * @package app\modules\Driving\Repositories
 */
class MovementPatternRepository
{
    /**
     * @param MovementPattern $movementPattern
     * @param TransportState $state
     */
    public static function addTransportStateToRoad(MovementPattern &$movementPattern, TransportState $state): void
    {
        $movementPattern->addTransport($state);
    }

    /**
     * @param MovementPattern $movementPattern
     * @param TransportState $state
     */
    public static function removeTransportStateFromRoad(MovementPattern &$movementPattern, TransportState $state): void
    {
        $movementPattern->removeTransport($state);
    }
}