<?php
/**
 * Created by IntelliJ IDEA.
 * User: ahmad
 * Date: 26.05.2019
 * Time: 17:01
 */

namespace frontend\modules\api\controllers;

use common\models\Project;
use yii\rest\ActiveController;


class ProjectController extends ActiveController
{
    public $modelClass = \frontend\modules\api\models\Project::class;
}