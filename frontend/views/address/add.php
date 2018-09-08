<?php

/* @var $userId int */
/* @var $countryCodeList array */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $address frontend\models\Address */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавить новый адрес';
$this->params['breadcrumbs'][] = [
    'label' => "Просмотр информации о пользователе (ID: {$userId})",
    'url' => ['user/view/', 'id' => $userId]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<br>
<br>
<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($address, 'postcode') ?>
        <?= $form->field($address, 'country_code_id')->dropDownList($countryCodeList, ['prompt' => '']) ?>
        <?= $form->field($address, 'city') ?>
        <?= $form->field($address, 'street') ?>
        <?= $form->field($address, 'house_number') ?>
        <?= $form->field($address, 'apartment_number') ?>
        <br>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
    <br>
</div>
