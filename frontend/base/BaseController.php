<?php
/**
 * Created by topalek
 * Date: 25.01.2021
 * Time: 20:39
 */

namespace frontend\base;


use common\models\CartItem;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemCount'] = CartItem::getTotalCount();

        return parent::beforeAction($action);
    }
}
