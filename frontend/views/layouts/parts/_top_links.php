<?php

use yii\helpers\Html;

?>

<?= Html::a('About', ['/site/signup']) ?>
<?php
if (Yii::$app->user->isGuest): ?>
    <?= Html::a('Sign in', ['/site/sign-in']) ?>
    <?= Html::a('Signup', ['/site/signup']) ?>
<?php
else: ?>
    <?= Html::a('Logout (' . Yii::$app->user->identity->username . ')', ['/site/logout'], ['data-method' => 'post']) ?>
<?php
endif; ?>
