<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $user frontend\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Редактировать данные пользователя (ID: {$user->id})";
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<h1 class="text-center col-md-6 col-md-offset-3"><?= Html::encode($this->title) ?></h1>
<br>
<br>
<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($user, 'login') ?>
        <?= $form->field($user, 'email') ?>
        <?= $form->field($user, 'password')->passwordInput() ?>
        <?= $form->field($user, 'password_repeat')->passwordInput() ?>
        <?= $form->field($user, 'first_name') ?>
        <?= $form->field($user, 'last_name') ?>
        <?= $form->field($user, 'gender')->radioList($user->getGenderList(), ['class' => 'radio-inline']) ?>
        <br>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
    <br>
</div>
