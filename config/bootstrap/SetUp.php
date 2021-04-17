<?php


namespace app\config\bootstrap;

use app\modules\Driving\Server\DrivingEvent;
use app\modules\Driving\Services\DrivingService;
use app\modules\Driving\Services\MovementPatternService;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use SplObjectStorage;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class SetUp
 * @package app\config\bootstrap
 */
class SetUp implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(DrivingService::class, function () {
            return new DrivingService(
                IoServer::factory(
                    new HttpServer(
                        new WsServer(
                            new DrivingEvent(
                                new SplObjectStorage(),
                                new MovementPatternService()
                            )
                        )
                    ),
                    8000
                )
            );
        });
    }
}