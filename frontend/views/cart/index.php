<?php
/**
 * Created by topalek
 * Date: 14.01.2021
 * Time: 16:20
 *
 * @var $this View
 */

use common\models\Product;
use yii\helpers\Html;
use yii\web\View;

/**@var $items array */
$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">
    <?php
    if (!empty($items)): ?>
        <div class="card">
            <div class="card-header">
                <h3>Cart items</h3>
            </div>
            <div class="card-body">
                <div class="grid col6 row-a">
                    <div class="cart-title">Product</div>
                    <div class="cart-title">Image</div>
                    <div class="cart-title">Price</div>
                    <div class="cart-title">QTY</div>
                    <div class="cart-title">Total price</div>
                    <div class="cart-title">Actions</div>
                    <?php

                    foreach ($items as $item) :?>
                        <div class="cart-item"><?= $item['name'] ?></div>
                        <div class="cart-item"><?= Html::img(
                                Product::formatImgUrl($item['image']),
                                ['class' => 'img-fluid']
                            ) ?>
                        </div>
                        <div class="cart-item"><?= $item['price'] ?></div>
                        <div class="cart-item"><?= $item['quantity'] ?></div>
                        <div class="cart-item"><?= $item['total_price'] ?></div>
                        <div class="cart-item"><?= Html::a(
                                '<i class="fa fa-trash-o"></i>',
                                ['cart/delete', 'id' => $item['id']],
                                [
                                    'class'        => 'btn btn-outline-danger btn-sm',
                                    'data-method'  => 'post',
                                    'data-confirm' => 'Are you sure you want to remove this item from cart?',
                                ]
                            ) ?></div>
                    <?php
                    endforeach; ?>
                </div>
                <div class="row">
                    <div class="col">
                        <?= Html::a('Checkout', ['/cart/checkout'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

            </div>
        </div>
    <?php
    else: ?>
        <div class="row">
            <div class="col">
                <p class="text-muted">
                    Cart is empty!
                </p>
            </div>
        </div>
    <?php
    endif; ?>
</div>

<style>
    .grid {
        display: grid;
        grid-gap: 10px;
        align-items: center;
    }

    .grid.col6 {
        grid-template-columns: repeat(6, 1fr);
    }

    .grid.row-a {
        grid-template-rows: auto;
    }
</style>
