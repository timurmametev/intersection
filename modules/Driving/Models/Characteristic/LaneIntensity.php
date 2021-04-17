<?php

namespace app\modules\Driving\Models\Characteristic;

/**
 * Class LaneIntensity
 * @package app\modules\Driving\Models\Characteristic
 */
class LaneIntensity
{
    /**
     * Пропускная способность полосы в секунду
     */
    public const DEFAULT_VALUE = 1;

    /**
     * @var int
     */
    private $value;

    /**
     * LaneIntensity constructor.
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