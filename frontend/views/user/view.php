<?php

/* @var $this yii\web\View */
/* @var $pages yii\data\Pagination */
/* @var $user frontend\models\User */
/* @var $addressList[] frontend\models\Address */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = "Просмотр информации о пользователе (ID: {$user->id})";
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<br>
<div class="text-right">
    <?= Html::a('Добавить новый адрес', ['address/add', 'usr' => Html::encode($user->id)], [
        'class' => 'btn btn-lg btn-success',
    ]) ?>
</div>
<hr>
<div>
    <br>
    <div class="lead">
        <div class="col-lg-6 text-center">
            <p>Логин: <span class="text-muted"><?= Html::encode($user->login) ?></span></p>
            <p>Email: <span class="text-muted"><?= Html::encode($user->email) ?></span></p>
            <p>Дата создания: <span class="text-muted"><?= Html::encode($user->getFormatCreatedAt($user->created_at)) ?></span></p>
        </div>
        <div class="col-lg-6 text-center">
            <p>Имя: <span class="text-muted"><?= Html::encode($user->first_name) ?></span></p>
            <p>Фамилия: <span class="text-muted"><?= Html::encode($user->last_name) ?></span></p>
            <p>Пол: <span class="text-muted"><?= Html::encode($user->getGenderValue($user->gender)) ?></span></p>
        </div>
        <br>
    </div>
    <br><br><br>
    <p class="h3 text-center text-primary">Адрес<?= count($user->getAddresses()) > 1 ? 'а' : '' ?> пользователя</p>
    <br>
    <?php foreach ($addressList as $address) : ?>
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">Почтовый индекс</th>
                <th class="text-center">Код страны</th>
                <th class="text-center">Название города</th>
                <th class="text-center">Название улицы</th>
                <th class="text-center">Номер дома</th>
                <th class="text-center">Номер офиса/квартиры</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= Html::encode($address->postcode) ?></td>
                    <td><?= Html::encode($address->getCountry()->country_code) ?></td>
                    <td><?= Html::encode($address->city) ?></td>
                    <td><?= Html::encode($address->street) ?></td>
                    <td><?= Html::encode($address->house_number) ?></td>
                    <td><?= Html::encode($address->apartment_number) ?></td>
                </tr>
            </tbody>
        </table>
        <div class="text-right">
            <?= Html::a('Редактировать', [
                'address/edit',
                'usr' => Html::encode($user->id),
                'id' => Html::encode($address->id)
            ], [
                'class' => 'btn btn-primary',
            ]) ?>
            <?= Html::a('Удалить', [
                'address/delete',
                'usr' => Html::encode($user->id),
                'id' => Html::encode($address->id)
            ], [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Вы уверены, что хотите удалить данного пользователя?',
                'data-method' => 'post',
            ]) ?>
        </div>
        <br>
        <hr>
        <br>
    <?php endforeach; ?>
</div>
<div class="text-center">
    <?= LinkPager::widget([
        'pagination' => $pages,
        'prevPageLabel' => 'Предыдущая',
        'nextPageLabel' => 'Следующая',
        'options' => ['class' => 'pagination pagination-lg'],
    ]); ?>
</div>
