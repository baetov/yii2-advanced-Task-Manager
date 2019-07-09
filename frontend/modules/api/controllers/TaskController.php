<?php
/**
 * Created by IntelliJ IDEA.
 * User: ahmad
 * Date: 26.05.2019
 * Time: 17:01
 */

namespace frontend\modules\api\controllers;

use common\models\Task;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class TaskController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Task::find()
        ]);
    }
    public function actionView($id)
    {
        return Task::findOne($id);
    }
}