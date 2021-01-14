<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\Response;

class CartController extends Controller
{
    public function actionAdd($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            return ['status' => true, 'msg' => 'Added to cart'];
        }
        return ['status' => false, 'msg' => 'Only POST method is allowed'];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
