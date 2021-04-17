<?php


namespace app\modules\Driving\Models\Characteristic;

/**
 * Class LaneSerialNumber
 * @package app\modules\Driving\Models\Characteristic
 */
class LaneSerialNumber
{
    /**
     * @var int
     */
    private $value;

    /**
     * LaneSerialNumber constructor.
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