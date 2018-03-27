<?php
$this->title = "Регистрация";

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h1><?= Html::encode($this->title)?></h1>
<?php $form = ActiveForm::begin()  ?>
<?= $form->field($model,'usersurname') ?>
<?= $form->field($model,'username') ?>
<?= $form->field($model,'email') ?>
<?= $form->field($model,'password')->passwordInput() ?>
<?= $form->field($model,'password2')->passwordInput() ?>
<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>
