<?php

namespace app\modules\Driving\Models\Characteristic;

use app\modules\Driving\Dto\Characteristic\LocationDTO;

/**
 * Class Location
 * @package app\modules\Driving\Models\Characteristic
 */
class Location
{
    /**
     * @var Coordinate
     */
    private $x;

    /**
     * @var Coordinate
     */
    private $y;

    /**
     * Location constructor.
     *
     * @param Coordinate $x
     * @param Coordinate $y
     */
    public function __construct(Coordinate $x, Coordinate $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return LocationDTO
     */
    public function getLocation(): LocationDTO
    {
        return new LocationDTO([
            'x' => $this->x->getValue(),
            'y' => $this->y->getValue(),
        ]);
    }

    /**
     * @param LocationDTO $dto
     */
    public function setLocation(LocationDTO $dto): void
    {
        $this->x = new Coordinate($dto->x);
        $this->y = new Coordinate($dto->y);
    }
}