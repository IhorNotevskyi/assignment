<?php

/* @var $this yii\web\View */
/* @var $pages yii\data\Pagination */
/* @var $userList[] frontend\models\User */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Список всех пользователей';
?>
<br>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<br>
<div class="text-right">
    <?= Html::a('Добавить нового пользователя', ['user/add'], [
        'class' => 'btn btn-lg btn-success',
    ]) ?>
</div>
<hr>
<?php foreach ($userList as $user) : ?>
    <div>
        <p class="h3 text-center text-primary col-lg-12">Пользователь (ID: <?= Html::encode($user->id) ?>)</p>
        <br>
        <div class="lead">
            <div class="col-lg-6 text-center">
                <p>Логин: <span class="text-muted"><?= Html::encode($user->login) ?></span></p>
                <p>Email: <span class="text-muted"><?= Html::encode($user->email) ?></span></p>
                <p>Пол: <span class="text-muted"><?= Html::encode($user->getGenderValue($user->gender)) ?></span></p>
                <p>Дата создания: <span class="text-muted"><?= Html::encode($user->getFormatCreatedAt($user->created_at)) ?></span></p>
            </div>
            <div class="col-lg-6 text-center">
                <p>Имя: <span class="text-muted"><?= Html::encode($user->first_name) ?></span></p>
                <p>Фамилия: <span class="text-muted"><?= Html::encode($user->last_name) ?></span></p>
                <p>Количество адресов: <span class="text-muted"><?= count($user->getAddresses()) ?></span></p>
            </div>
        </div>
        <div class="col-lg-12 text-right">
            <?= Html::a('Просмотреть', ['user/view', 'id' => Html::encode($user->id)], [
                'class' => 'btn btn-info',
            ]) ?>
            <?= Html::a('Редактировать', ['user/edit', 'id' => Html::encode($user->id)], [
                'class' => 'btn btn-primary',
            ]) ?>
            <?= Html::a('Удалить', ['user/delete', 'id' => Html::encode($user->id)], [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Вы уверены, что хотите удалить данного пользователя?',
                'data-method' => 'post',
            ]) ?>
        </div>
        <hr class="col-lg-12">
    </div>
<?php endforeach; ?>
<div class="col-lg-12 text-center">
    <?= LinkPager::widget([
        'pagination' => $pages,
        'prevPageLabel' => 'Предыдущая',
        'nextPageLabel' => 'Следующая',
        'options' => ['class' => 'pagination pagination-lg'],
    ]); ?>
</div>
