<?php


namespace app\modules\Driving\Server;

use app\modules\Driving\Models\MovementPattern;
use app\modules\Driving\Services\MovementPatternService;
use DateTime;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

/**
 * Class DrivingEvent
 * @package app\modules\Driving\Server
 */
class DrivingEvent implements MessageComponentInterface
{
    /**
     * @var SplObjectStorage|ConnectionInterface[]
     */
    protected $clients;

    /**
     * @var MovementPatternService
     */
    protected $movementPatternService;

    /**
     * @var DateTime
     */
    protected $lastMove;

    /**
     * @var DateTime
     */
    protected $lastSpawn;

    /**
     * @var MovementPattern
     */
    private $pattern;

    /**
     * DrivingEvent constructor.
     *
     * @param SplObjectStorage $objectStorage
     * @param MovementPatternService $movementPattern
     */
    public function __construct(SplObjectStorage $objectStorage, MovementPatternService $movementPattern)
    {
        $this->lastMove = new DateTime();
        $this->lastSpawn = new DateTime();
        $this->clients = $objectStorage;
        $this->movementPatternService = $movementPattern;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->close();
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msg
     * @throws Exception
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        if ($msg == 'getMovementPattern') {
            if ($this->pattern) {
                $spawned = $this->movementPatternService->updateMovementPattern(
                    $this->pattern,
                    $this->lastMove,
                    $this->lastSpawn
                );

                if ($spawned) {
                    $this->lastSpawn = new DateTime();
                }
            } else {
                $this->pattern = $this->movementPatternService->createDefaultMovementPattern();
            }

            $response = $this->movementPatternService->prepareResponseData($this->pattern);

            foreach ($this->clients as $client) {
                $client->send(json_encode($response));
            }

            $this->lastMove = new DateTime();
        }
    }
}
