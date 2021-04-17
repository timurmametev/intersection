<?php


namespace app\modules\Driving\Models\Transport;

/**
 * Interface TransportInterface
 * @package app\modules\Driving\Models\Transport
 */
interface TransportInterface
{
    /**
     * @return string
     */
    public function getUuid(): string;

    /**
     * @return int
     */
    public function getMinSpeed(): int;

    /**
     * @return int
     */
    public function getMaxSpeed(): int;
}