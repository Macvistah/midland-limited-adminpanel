<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Help */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['action'=>\yii\helpers\Url::to(['help/title'])]); ?>
            <?= $form->field($model, 'title')->textInput() ?>
            <div class="form-group pull-right">
                <?= Html::submitButton('Save', ['class' => 'btn btn-info btn-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


</div>
