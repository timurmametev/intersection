<?php

namespace app\modules\Driving\Dto\Response;

use app\common\collection\CollectionFactory;
use app\common\collection\CollectionTemplate;
use app\common\dto\BaseDTO;
use app\modules\Driving\Models\Road\Road;
use app\modules\Driving\Models\Transport\TransportState;
use Exception;

/**
 * Class MovementPatternResponseDTO
 * @package app\modules\Driving\Dto\Response
 *
 * @property Road|RoadDTO $road
 * @property TransportState[]|CollectionTemplate $transport
 */
class MovementPatternResponseDTO extends BaseDTO
{
    protected $attributeNames = [
        'road',
        'transport'
    ];


    /**
     * @throws Exception
     */
    public function processData()
    {
        if ($this->road) {

            $collection = CollectionFactory::create(new LaneStateDTO());

            foreach ($this->road->getLanes() as $lane) {
                $collection->addData([
                    'uuid'          => $lane->getLaneUuid(),
                    'width'         => $lane->getWidth(),
                    'direction'     => $lane->getDirection(),
                    'startLocation' => $lane->getStartLocation($this->road)->getLocation()
                ]);
            }

            $this->road = new RoadDTO([
                'len'           => $this->road->getLength(),
                'startLocation' => $this->road->getStartLocation(),
                'lanes'         => $collection
            ]);
        }

        if ($this->transport) {
            $collection = CollectionFactory::create(new TransportDTO());

            foreach ($this->transport as $transportState) {
                $collection->addData([
                    'uuid'     => $transportState->getTransportUuid(),
                    'speed'    => $transportState->getSpeed(),
                    'location' => $transportState->getLocation()->getLocation(),
                    'laneUuid' => $transportState->getLane()->getLaneUuid()
                ]);
            }

            $this->transport = $collection;
        }
    }
}