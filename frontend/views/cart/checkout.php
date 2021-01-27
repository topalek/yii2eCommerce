<?php

use common\models\CartItem;
use common\models\Order;
use common\models\OrderAddress;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/**
 * Created by topalek
 * Date: 27.01.2021
 * Time: 9:41
 */

/* @var $this \yii\web\View */
/* @var $order Order */
/* @var $orderAddress OrderAddress */
/* @var $cartItems array */

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = [
    'label' => 'Cart',//Yii::t('shop', 'Cart'),
    'url'   => Url::to(['cart/index']),
];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="checkout__form">
        <?php
        $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-lg-7 col-md-6">
                <h6 class="coupon__code">
                    <span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click
                        here</a> to enter your code
                </h6>
                <h6 class="checkout__title">Billing Details</h6>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout__input">
                            <?= $form->field($order, 'firstname')->textInput() ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout__input">
                            <?= $form->field($order, 'lastname')->textInput() ?>
                        </div>
                    </div>
                </div>
                <div class="checkout__input">
                    <?= $form->field($orderAddress, 'address')->textInput() ?>
                </div>
                <div class="checkout__input">
                    <?= $form->field($orderAddress, 'city')->textInput() ?>
                </div>
                <div class="checkout__input">
                    <?= $form->field($orderAddress, 'state')->textInput() ?>
                </div>
                <div class="checkout__input">
                    <?= $form->field($orderAddress, 'country')->textInput() ?>
                </div>
                <div class="checkout__input">
                    <?= $form->field($orderAddress, 'zipcode')->textInput() ?>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout__input">
                            <p>Phone<span>*</span></p>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout__input">
                            <p>Email<span>*</span></p>
                            <input type="text">
                        </div>
                    </div>
                </div>
                <div class="checkout__input__checkbox">
                    <label for="acc">
                        Create an account?
                        <input type="checkbox" id="acc">
                        <span class="checkmark"></span>
                    </label>
                    <p>Create an account by entering the information below. If you are a returning customer
                        please login at the top of the page</p>
                </div>
                <div class="checkout__input">
                    <p>Account Password<span>*</span></p>
                    <input type="text">
                </div>
                <div class="checkout__input__checkbox">
                    <label for="diff-acc">
                        Note about your order, e.g, special noe for delivery
                        <input type="checkbox" id="diff-acc">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="checkout__input">
                    <p>Order notes<span>*</span></p>
                    <input type="text"
                           placeholder="Notes about your order, e.g. special notes for delivery.">
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="checkout__order">
                    <h4 class="order__title">Your order</h4>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($cartItems as $cartItem) {
                            if ($i < 10) {
                                $k = '0' . $i;
                            }
                            $price = Yii::$app->formatter->asCurrency($cartItem['price'] * $cartItem['quantity']);
                            echo sprintf(
                                "<tr><td class='d-inline-block text-truncate'>%s. %s</td> <td>%s</td> <td>%s</td></tr>",
                                $k,
                                $cartItem['name'],
                                $cartItem['quantity'],
                                $price
                            );
                            $i++;
                        } ?>
                        </tbody>

                    </table>
                    <ul class="checkout__total__products">

                    </ul>
                    <ul class="checkout__total__all">
                        <!--                                <li>Subtotal <span>$750.99</span></li>-->
                        <li>Total <span><?= Yii::$app->formatter->asCurrency(CartItem::getTotalPrice()) ?></span></li>
                    </ul>
                    <div class="checkout__input__checkbox">
                        <label for="acc-or">
                            Create an account?
                            <input type="checkbox" id="acc-or">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                        ut labore et dolore magna aliqua.</p>
                    <div class="checkout__input__checkbox">
                        <label for="payment">
                            Check Payment
                            <input type="checkbox" id="payment">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="checkout__input__checkbox">
                        <label for="paypal">
                            Paypal
                            <input type="checkbox" id="paypal">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <button type="submit" class="site-btn">PLACE ORDER</button>
                </div>
            </div>
        </div>
        <?php
        ActiveForm::end() ?>
    </div>
</section>
<!-- Checkout Section End -->
