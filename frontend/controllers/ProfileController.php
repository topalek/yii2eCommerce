<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 23:43
 */

namespace frontend\controllers;


use common\models\User;
use frontend\base\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class ProfileController extends BaseController
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
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', 'Profile information was successfully updated');
        }
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
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('You are allowed to make only ajax request');
        }
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
