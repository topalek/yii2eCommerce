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

class UserController extends Controller
{
    public $layout = 'user-layout';

    public function actionProfile()
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();

        return $this->render(
            'profile',
            [
                'user' => $user,
            ]
        );
    }

    public function actionAddress()
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();
        $address = $user->address;
        return $this->render('address', ['address' => $address]);
    }

}
