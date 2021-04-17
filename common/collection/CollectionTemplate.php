<?php

namespace app\common\collection;

use Exception;

/**
 * Class CollectionTemplate
 * @package app\common\collection
 */
class CollectionTemplate extends BaseCollection
{
    /**
     * @var null|string
     */
    private $DTOClassName = null;

    /**
     * @param string $name
     * @throws Exception
     */
    public function setClassName(string $name): void
    {
        if (class_exists($name)) {
            $this->DTOClassName = $name;
        } else {
            throw new Exception('Invalid DTO class name');
        }
    }

    /**
     * @param array $data
     * @param bool $multiple
     */
    public function addData(array $data, bool $multiple = false): void
    {
        $className = $this->DTOClassName;

        if ($className) {
            if ($multiple) {
                $processedData = [];

                foreach ($data as $key => $item) {
                    $processedData[$key] = new $className($item);
                }

                parent::addDataMultiple($processedData);
            } else {
                $processedData = new $className($data);

                parent::addDataSingle($processedData);
            }
        }
    }
}