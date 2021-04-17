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

            $this->lastMove = new DateTime();

            $this->pattern = $this->pattern
                ? $this->movementPatternService->updateMovementPattern($this->pattern, $this->lastMove)
                : $this->movementPatternService->createDefaultMovementPattern();

            /*if ($this->pattern) {
                $this->movementPatternService->updateMovementPattern($this->pattern, $this->lastMove);
            } else {
                $this->pattern = $this->movementPatternService->createDefaultMovementPattern();
            }*/

            $response = $this->movementPatternService->prepareResponseData($this->pattern);

            foreach ($this->clients as $client) {
                $client->send(json_encode($response));
            }
        }
    }
}
