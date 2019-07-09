<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form/data'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUSES_LABELS) ?>


    <?php
    if (!$model->isNewRecord){
        echo $form->field($model, \common\models\Project::RELATIN_PROJECT_USERS)
            ->widget(\unclead\multipleinput\MultipleInput::class, [
                //https://github.com/unclead/yii2-multiple-input
                'id'                => 'project-users-widget',
                'max'               => 10,
                'min'               => 0, // should be at least 2 rows
                'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER,
                'columns' => [
                    [
                        'name' => 'project_id',
                        'type' => 'hiddenInput',
                        'defaultValue' => $model->id,
                    ],

                    [
                        'name' => 'user_id',
                        'type' => 'dropDownList',
                        'title' => 'пользователь',
                        'items' => $users
                    ],
                    [
                        'name' => 'role',
                        'type' => 'dropDownList',
                        'title' => 'роль',
                        'items' => \common\models\ProjectUser::ROLES_LABELS,
                    ]

                ]
            ])
            ->label(false);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>
