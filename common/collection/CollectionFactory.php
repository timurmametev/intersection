<?php

namespace app\common\collection;

use app\common\dto\DTOInterface;
use Exception;

/**
 * Class CollectionFactory
 * @package app\common\collection
 */
class CollectionFactory
{
    /**
     * @param DTOInterface $model
     * @return CollectionTemplate
     * @throws Exception
     */
    public static function create(DTOInterface $model): CollectionTemplate
    {
        return self::newCollection(
            self::getObjectFullName($model)
        );
    }

    /**
     * @param string $DTOClassName
     * @return CollectionTemplate
     * @throws Exception
     */
    private static function newCollection(string $DTOClassName): CollectionTemplate
    {
        $collection = new CollectionTemplate();
        $collection->setClassName($DTOClassName);
        return $collection;
    }

    /**
     * @param DTOInterface $model
     * @return string
     */
    private static function getObjectFullName(DTOInterface $model): string
    {
        return (new \ReflectionClass($model))->getName();
    }

}