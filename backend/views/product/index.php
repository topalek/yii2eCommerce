<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'id',
                [
                    'attribute' => 'image',
                    'value'     => function ($model) {
                        return Html::img($model->getImgUrl(), ['style' => 'width:50px']);
                    },
                    'format'    => 'raw',
                ],
                'name',
//                'imgUrl:image',
                [
                    'attribute' => 'status',
                    'value'     => function ($model) {
                        return Html::tag(
                            'span',
                            $model->status ? 'Active' : 'Draft',
                            ['class' => $model->status ? 'badge badge-success' : 'badge badge-danger']
                        );
                    },
                    'format'    => 'raw',
                ],
                'price:currency',
                'created_at:datetime',
                'updated_at:datetime',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>


</div>
