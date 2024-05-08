<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['action'=>\yii\helpers\Url::to(['product/category'])]); ?>
            <?= $form->field($model, 'name')->textInput() ?>
            <div class="form-group pull-right">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


</div>
