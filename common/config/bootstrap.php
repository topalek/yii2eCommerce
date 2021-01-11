<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

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
