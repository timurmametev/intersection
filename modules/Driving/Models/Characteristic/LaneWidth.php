<?php

namespace app\modules\Driving\Models\Characteristic;

/**
 * Class LaneWidth
 * @package app\modules\Driving\Models\Characteristic
 */
class LaneWidth
{
    public const DEFAULT_VALUE = 5;

    /**
     * @var int
     */
    private $value;

    /**
     * LaneWidth constructor.
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