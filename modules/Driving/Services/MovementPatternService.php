<?php

namespace app\modules\Driving\Services;

use app\modules\Driving\Dto\Response\MovementPatternResponseDTO;
use app\modules\Driving\Models\Characteristic\LaneDirection;
use app\modules\Driving\Models\Characteristic\LaneWidth;
use app\modules\Driving\Models\Characteristic\TransportSpeed;
use app\modules\Driving\Models\MovementPattern;
use app\modules\Driving\Models\Transport\TransportState;
use app\modules\Driving\Repositories\MovementPatternRepository;
use app\modules\Driving\Repositories\Road\LaneStateRepository;
use app\modules\Driving\Repositories\Road\RoadRepository;
use app\modules\Driving\Repositories\Transport\Car\CarRepository;
use app\modules\Driving\Repositories\Transport\TransportStateRepository;
use DateTime;
use Exception;

/**
 * Class MovementPatternService
 * @package app\modules\Driving\Services
 */
class MovementPatternService
{
    /**
     * @throws Exception
     */
    public function createDefaultMovementPattern(): MovementPattern
    {
        $pattern = $this->buildDefaultRoad();

        $this->createTransport($pattern, LaneDirection::DIRECTION_FORWARD);

        $this->createTransport($pattern, LaneDirection::DIRECTION_BACKWARD);

        return $pattern;
    }

    /**
     * @param MovementPattern $movementPattern
     * @param DateTime $lastMove
     * @param DateTime $lastSpawn
     * @return bool
     * @throws Exception
     */
    public function updateMovementPattern(MovementPattern $movementPattern, DateTime $lastMove, DateTime $lastSpawn): bool
    {
        $now = new DateTime();

        $deltaTime = $now->getTimestamp() - $lastMove->getTimestamp();
        $deltaTimeSpawn = $now->getTimestamp() - $lastSpawn->getTimestamp();

        //move all cars on the road
        foreach ($movementPattern->getTransportStates() as $transportState) {

            $transportState->move($deltaTime);
            $this->removeTransportIfLeftRoad($transportState, $movementPattern);
        }

        $spawned = false;

        //spawn new cars
        if ($deltaTimeSpawn >= MovementPattern::SPAWN_FREQUENCY) {
            $spawned = true;
            while ($deltaTimeSpawn > 0) {
                $deltaTimeSpawn -= MovementPattern::SPAWN_FREQUENCY;
                $deltaTimeSpawn = max($deltaTimeSpawn, 0);

                $carForward = $this->createTransport($movementPattern, LaneDirection::DIRECTION_FORWARD);

                if ($carForward) {
                    $carForward->move($deltaTimeSpawn);
                    $this->removeTransportIfLeftRoad($carForward, $movementPattern);
                }

                $carBackward = $this->createTransport($movementPattern, LaneDirection::DIRECTION_BACKWARD);

                if ($carBackward) {
                    $carBackward->move($deltaTimeSpawn);
                    $this->removeTransportIfLeftRoad($carBackward, $movementPattern);
                }
            }
        }

        return $spawned;
    }

    /**
     * @param TransportState $transportState
     * @param MovementPattern $movementPattern
     */
    private function removeTransportIfLeftRoad(TransportState $transportState, MovementPattern $movementPattern)
    {
        if (!$transportState->getLane()->checkLocationIsOnLane($transportState->getLocation(), $movementPattern->getRoad())) {
            MovementPatternRepository::removeTransportStateFromRoad($movementPattern, $transportState);
        }
    }

    /**
     * @return MovementPattern
     * @throws Exception
     */
    private function buildDefaultRoad(): MovementPattern
    {
        $road = RoadRepository::generateDefaultRoad();

        $laneBackward = LaneStateRepository::createLaneState(LaneDirection::DIRECTION_BACKWARD, LaneWidth::DEFAULT_VALUE, 0);
        $laneForward = LaneStateRepository::createLaneState(LaneDirection::DIRECTION_FORWARD, LaneWidth::DEFAULT_VALUE, 0);

        $road->addLane($laneBackward);
        $road->addLane($laneForward);

        return new MovementPattern($road);
    }

    /**
     * @param MovementPattern $pattern
     * @param int $direction
     * @return TransportState|null
     * @throws Exception
     */
    public function createTransport(MovementPattern &$pattern, int $direction): ?TransportState
    {
        $transportState = new TransportState(
            CarRepository::createNewCar()
        );

        $lanes = [];

        if ($direction == LaneDirection::DIRECTION_FORWARD) {
            $lanes = $pattern->getRoad()->getForwardLanes();
        } else if ($direction == LaneDirection::DIRECTION_BACKWARD) {
            $lanes = $pattern->getRoad()->getBackwardLanes();
        }

        if (empty($lanes)) {
            return null;
        }

        $laneState = array_pop($lanes);

        TransportStateRepository::fillProperties(
            $transportState,
            $pattern->getRoad(),
            new TransportSpeed(TransportSpeed::DEFAULT_TRANSPORT_SPEED),
            $laneState
        );

        MovementPatternRepository::addTransportStateToRoad($pattern, $transportState);

        return $transportState;
    }


    /**
     * @param MovementPattern $pattern
     * @return array
     */
    public function prepareResponseData(MovementPattern $pattern): array
    {
        $responseDTO = new MovementPatternResponseDTO([
            'road' => $pattern->getRoad(),
            'transport' => $pattern->getTransportStates()
        ]);

        return $responseDTO->getData();
    }
}