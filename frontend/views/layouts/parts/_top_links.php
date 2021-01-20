<?php

use yii\bootstrap4\Nav;
use yii\helpers\Html;

?>

<?= Html::a('About', ['/site/about']) ?>
<?php
if (Yii::$app->user->isGuest): ?>
    <?= Html::a('Sign in', ['/site/sign-in']) ?>
    <?= Html::a('Signup', ['/site/signup']) ?>
<?php
else: ?>
    <?= Nav::widget(
        [
            'items' => [
                [
                    'label'           => Yii::$app->user->identity->getDisplayName(),
                    'items'           => [
                        [
                            'label' => 'Profile',
                            'url'   => ['/user/profile', 'id' => Yii::$app->user->identity->getId()],
                        ],
                        [
                            'label'       => 'Logout',
                            'url'         => ['/site/logout'],
                            'linkOptions' => [
                                'data-method' => 'post',
                            ],
                        ],
                    ],
                    'dropdownOptions' => ['class' => 'dropdown-menu-right'],
                ],
            ],
        ]
    ); ?>
<?php
endif; ?>
