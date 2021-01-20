<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
{
    public $layout = 'user-layout';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    //                    [
                    //                        'actions' => ['index', 'address', 'update-address'],
                    //                        'allow'   => true,
                    //                    ],
                    [
                        'actions' => ['index', 'address', 'update-address'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
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
