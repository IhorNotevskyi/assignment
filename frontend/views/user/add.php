<?php

/* @var $countryCodeList array */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $user frontend\models\User */
/* @var $address frontend\models\Address */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавить нового пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
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
        <h3 class="text-center">Адрес пользователя</h3>
        <?= $form->field($address, 'postcode') ?>
        <?= $form->field($address, 'country_code_id')->dropDownList($countryCodeList, ['prompt' => '']) ?>
        <?= $form->field($address, 'city') ?>
        <?= $form->field($address, 'street') ?>
        <?= $form->field($address, 'house_number') ?>
        <?= $form->field($address, 'apartment_number') ?>
        <br>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>
