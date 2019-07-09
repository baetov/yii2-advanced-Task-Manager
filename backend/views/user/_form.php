<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = \yii\bootstrap\ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form/data'],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],
        ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATUS_LABELS) ?>
    <?= $form->field($model, 'avatar')
        ->fileInput(['accept' => 'image/*'])
        ->label('Avatar'.Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW)))?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>

</div>
