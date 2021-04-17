<?php

namespace app\modules\Driving\Services;

use Ratchet\Server\IoServer;

class DrivingService
{
    /**
     * @var IoServer
     */
    private $server;

    /**
     * DrivingService constructor.
     *
     * @param IoServer $ioServer
     */
    public function __construct(IoServer $ioServer)
    {
        $this->server = $ioServer;
    }

    public function run()
    {
        $this->server->run();
    }
}