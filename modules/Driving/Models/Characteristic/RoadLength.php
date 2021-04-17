<?php

namespace app\modules\Driving\Models\Characteristic;

/**
 * Class RoadLength
 * @package app\modules\Driving\Models\Characteristic
 */
class RoadLength
{
    public const DEFAULT_VALUE = 600;

    /**
     * @var int
     */
    private $value;

    /**
     * RoadLength constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}