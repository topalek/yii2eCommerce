<?php

use common\models\User;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@uploads', dirname(dirname(__DIR__)) . '/frontend/web/storage');

/**
 * @param      $data
 * @param int  $num
 * @param bool $highlight
 */
function dd($data, $num = 10, $highlight = true)
{
    dump($data, $num, $highlight);
    die();
}

/**
 * @param      $data
 * @param int  $num
 * @param bool $highlight
 */
function dump($data, $num = 10, $highlight = true)
{
    \yii\helpers\VarDumper::dump($data, $num, $highlight);
}

function getImgSize($src)
{
    return @getimagesize($src);
}

/**
 * @return bool
 */
function isGuest(): bool
{
    return Yii::$app->user->isGuest;
}

function currUser(): ?User
{
    return Yii::$app->user->identity;
}

function currUserId(): ?int
{
    return Yii::$app->user->getId();
}
