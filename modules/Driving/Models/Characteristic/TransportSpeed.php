<?php


namespace app\modules\Driving\Models\Characteristic;

/**
 * Class TransportSpeed
 * @package app\modules\Driving\Models\Characteristic
 */
class TransportSpeed
{
    public const DEFAULT_MAX_VALUE = 100;
    public const DEFAULT_MIN_VALUE = 20;
    public const DEFAULT_TRANSPORT_SPEED = 60;

    /**
     * @var int
     */
    private $value;

    /**
     * TransportSpeed constructor.
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