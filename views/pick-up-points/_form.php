<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PickUpPoints */
/* @var $form yii\widgets\ActiveForm */
if (!$model->isNewRecord){
    $title = 'Edit Pick-up Point';
}
else{
    $title = 'Create New Pick-up Point';
}
?>

<div class="pick-up-points-form">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title"><?= $title ?></h4>
                    <p class="card-category">Fill all the fields</p>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Pick-up Point Name</label>
                                <?= $form->field($model, 'p_name')->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Charge</label>
                                <?= $form->field($model, 'charge')->textInput()->label(false) ?>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-info pull-right']) ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
