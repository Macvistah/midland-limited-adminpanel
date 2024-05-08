<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PurchasesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchases-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prod_id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'original_qty') ?>

    <?= $form->field($model, 'available_qty') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'payment_code') ?>

    <?php // echo $form->field($model, 'purchase_no') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'price_per_unit') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'final_price_per_unit') ?>

    <?php // echo $form->field($model, 'create_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
