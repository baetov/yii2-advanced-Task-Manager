<?php

namespace common\modules\chat\controllers;

use common\modules\chat\components\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;
use Yii;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            Yii::$app->params['chat.port']
        );

    echo 'server works'.PHP_EOL;
    $server->run();
    }
}
