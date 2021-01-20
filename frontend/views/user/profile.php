<?php
/**
 * Created by topalek
 * Date: 15.01.2021
 * Time: 18:14
 *
 * @var $user    User
 * @var $address UserAddress
 * @var $this    View
 */

use common\models\User;
use common\models\UserAddress;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = $user->getDisplayName() . ' profile';
?>
<div class="col">
    <div class="card">
        <h5 class="card-header">User info</h5>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($user, 'firstname')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($user, 'lastname')->textInput() ?>
                </div>
            </div>
            <?= $form->field($user, 'username')->textInput() ?>

            <?= $form->field($user, 'email')->textInput() ?>

            <?= Html::button(
                'Change password',
                ['onclick' => '$(this).next(".new-password").toggle()', 'class' => 'btn btn-link']
            ) ?>
            <div class="new-password" style="display: none">
                <div class="row">
                    <div class="col">
                        <?= $form->field($user, 'password')->passwordInput() ?>
                    </div>
                    <div class="col">
                        <?= $form->field($user, 'passwordConfirm')->passwordInput() ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'primary-btn']) ?>
            </div>

            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>


