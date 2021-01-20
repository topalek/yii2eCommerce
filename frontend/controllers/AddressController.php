<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use common\models\User;
use Yii;
use yii\web\Controller;

class AddressController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionUpdateAddress()
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();
        $address = $user->address;
        $success = false;
        if ($address->load(Yii::$app->request->post()) && $address->save()) {
            $success = true;
        }
        return $this->renderAjax('address_form', ['address' => $address, 'success' => $success]);
    }
}
