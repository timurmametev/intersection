<?php

namespace app\modules\Driving\Models\Characteristic;

/**
 * Class Coordinate
 * @package app\modules\Driving\Models\Characteristic
 */
class Coordinate
{
    /**
     * @var integer
     */
    private $coordinate;

    /**
     * Coordinate constructor.
     * @param integer $coordinate
     */
    public function __construct(int $coordinate)
    {
        $this->coordinate = $coordinate;
    }

    /**
     * @return integer
     */
    public function getValue(): int
    {
        return $this->coordinate;
    }
}