<?php


use yii\bootstrap4\Nav;

$items = [];

$items[] = ['label' => 'About', 'url' => ['/site/about']];
$items[] = ['label' => 'Cart', 'url' => ['/cart/index']];
if (Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Login', 'url' => ['/site/login']];
    $items[] = ['label' => 'Signup', 'url' => ['/site/signup']];
} else {
    $items[] = [
        'label'           => Yii::$app->user->identity->getDisplayName(),
        'items'           => [
            [
                'label' => 'Profile',
                'url'   => ['/profile'],
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
    ];
}

?>
<?= Nav::widget(['items' => $items,]) ?>

