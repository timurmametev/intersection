<?php

namespace app\modules\Driving\Models\Characteristic;

/**
 * Class RoadPriority
 * @package app\modules\Driving\Models\Characteristic
 */
class RoadPriority
{
    public const DEFAULT_VALUE = 0;

    /**
     * @var int
     */
    private $value;

    /**
     * RoadPriority constructor.
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