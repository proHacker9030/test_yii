<?php

use yii\helpers\Url;
?>

<h3>Ваша ссылка активации:</h3>
<br>

<?php $absoluteBaseUrl = Url::base(true) ?>
<a href="<?= \yii\helpers\Url::to(['/site/activate','hash' => $model->activation_code])?>">
    <?= $absoluteBaseUrl.'/site/activate/?hash='.$model->activation_code ?>
</a>
