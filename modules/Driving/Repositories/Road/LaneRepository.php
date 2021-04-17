<?php

namespace app\modules\Driving\Repositories\Road;

use app\modules\Driving\Models\Characteristic\LaneIntensity;
use app\modules\Driving\Models\Characteristic\TransportSpeed;
use app\modules\Driving\Models\Road\Lane;
use Exception;
use Ramsey\Uuid\Uuid;

class LaneRepository
{
    /**
     * @return Lane
     * @throws Exception
     */
    public static function createLane(): Lane
    {
        return new Lane(
            Uuid::uuid4(),
            new LaneIntensity(LaneIntensity::DEFAULT_VALUE),
            new TransportSpeed(TransportSpeed::DEFAULT_MAX_VALUE)
        );
    }
}