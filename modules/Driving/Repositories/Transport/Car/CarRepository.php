<?php

namespace app\modules\Driving\Repositories\Transport\Car;

use app\modules\Driving\Models\Characteristic\TransportSpeed;
use app\modules\Driving\Models\Transport\Car\Car;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * Class CarRepository
 * @package app\modules\Driving\Repositories\Transport\Car
 */
class CarRepository
{
    /**
     * @return Car
     * @throws Exception
     */
    public static function createNewCar(): Car
    {
        return new Car(
            Uuid::uuid4(),
            new TransportSpeed(TransportSpeed::DEFAULT_MIN_VALUE),
            new TransportSpeed(TransportSpeed::DEFAULT_MAX_VALUE)
        );
    }
}