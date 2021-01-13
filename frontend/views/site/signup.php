<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="site-signup spad">
    <div class="container">
        <p>Please fill out the following fields to signup:</p>

        <div class="row">
            <div class="col-lg-5">
                <?php
                $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'lastname')->textInput() ?>
                    </div>
                </div>
                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'primary-btn', 'name' => 'signup-button']) ?>
                </div>

                <?php
                ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</section>
