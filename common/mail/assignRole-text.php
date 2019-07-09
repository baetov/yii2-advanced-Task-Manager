<?php
use yii\helpers\Html;
/**
 * @var $this \yii\web\View
 * @var $user \common\models\User
 * @var $project \common\models\Project
 * @var $role string
*/
?>
Привет <?= Html::encode($user->username) ?>
в проекте <?= Html::encode($project->title) ?> тебе назначена роль <?= $role?>
