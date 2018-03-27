<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Страница пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php if(Yii::$app->session->hasFlash('activationSuccess')): ?>
    <p style="color: red"><?=Yii::$app->session->getFlash('activationSuccess')?></p>
    <?php endif;?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить профиль', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить свой профиль?',
                'method' => 'post',
            ],
        ]) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'usersurname',
            'username',
            'email:email',
            //'password',
            //'activation_code',
            //'auth_key',
        ],
    ]) ?>
</div>
