<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Project title',
                'attribute' => 'project_id',
                'content' => function (\common\models\Task $model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project_id]);
                },
                'format' => 'html',
                'filter' => \common\models\Project::find()
                    ->select('title')
                    ->byUser(Yii::$app->user->id)
                    ->indexBy('id')
                    ->column(),
            ],
            'title',
            'description:ntext',
            ['attribute' => 'executor_id',
                'label' => 'Executor username',
                'value' => function (\common\models\Task $model) {
                    return (!is_null($model->executor_id)) ?
                        Html::a($model->executor->username, ['user/view', 'id' => $model->executor_id]) : 'Нет';
                },
                'format' => 'html',
                'filter' => \common\models\User::find()
                    ->select('username')
                    ->onlyActive()
                    ->andRole(\common\models\ProjectUser::ROLE_DEVELOPER)
                    ->indexBy('id')
                    ->column(),
            ],
            'started_at:datetime',
            'completed_at:datetime',
            ['attribute' => 'creator_id',
                'label' => 'Creator username',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator_id]);
                },
                'format' => 'html',
                'filter' => \common\models\User::find()
                    ->select('username')
                    ->onlyActive()
                    ->andRole(\common\models\ProjectUser::ROLE_MANAGER)
                    ->indexBy('id')
                    ->column(),
            ],
            ['attribute' => 'updater_id',
                'label' => 'Updater username',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->updater->username, ['user/view', 'id' => $model->updater_id]);
                },
                'format' => 'html',
                'filter' => \common\models\User::find()
                    ->select('username')
                    ->onlyActive()
                    ->andRole(\common\models\ProjectUser::ROLE_MANAGER)
                    ->orRole(\common\models\ProjectUser::ROLE_DEVELOPER)
                    ->indexBy('id')
                    ->column(),
            ],
            'created_at.datetime',
            'updated_at.datetime',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {take} {complete}',
                'buttons' => [
                    'take' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('hand-right');
                        return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
                            'confirm' => 'взять задачу ?',
                            'method' => 'post'
                        ]]);
                    },
                    'complete' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('ok');
                        return Html::a($icon, ['task/complete', 'id' => $model->id], ['data' => [
                            'confirm' => 'завершить задачу?',
                            'method' => 'post'
                        ]]);
                    }
                ],
                'visibleButtons' => [
                    'update' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'delete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'take' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'complete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
