<?php

namespace app\modules\Driving\Models\Characteristic;

/**
 * Class LaneDirection
 * @package app\modules\Driving\Models\Characteristic
 */
class LaneDirection
{
    const DIRECTION_FORWARD  = 1;
    const DIRECTION_BACKWARD = 0;

    /**
     * @var int
     */
    private $value;

    /**
     * LaneDirection constructor.
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

    public static function getDirectionMultiplier(int $dir): int
    {
        return ($dir == self::DIRECTION_FORWARD) ? 1 : -1;
    }
}