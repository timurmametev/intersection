<?php

namespace app\commands;

use app\modules\Driving\Services\DrivingService;
use yii\console\Controller;

/**
 * Class ServerController
 * @package app\commands
 */
class ServerController extends Controller
{
    /**
     * @var DrivingService
     */
    private $drivingService;

    /**
     * SiteController constructor.
     *
     * @param $id
     * @param $module
     * @param DrivingService $drivingService
     * @param array $config
     */
    public function __construct($id, $module, DrivingService $drivingService, $config = [])
    {
        $this->drivingService = $drivingService;

        parent::__construct($id, $module, $config);
    }

    public function actionRun()
    {
        $this->drivingService->run();
    }
}