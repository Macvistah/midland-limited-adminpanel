<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Purchases */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord){
    $title = 'Create Purchase';
}else{
    $title = 'Edit Purchase';
}

$product = isset($_GET['product_id'])  ? $_GET['product_id'] : null;

$suppliers = \yii\helpers\ArrayHelper::map(\app\models\Supplier::find()->all(),'id','contact_fname');
$products = \yii\helpers\ArrayHelper::map(\app\models\Product::find()->all(),'prod_id','prod_name');

?>
<div class="purchases-form">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>true,'options'=>['autocomplete'=>'off']]); ?>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <?php
                            if (!$product){
                            ?>
                            <div class="form-group">
                                <label class="bmd-label-floating">Product</label>
                                <?= $form->field($model, 'prod_id')->widget(\kartik\select2\Select2::className(),[
                                    'data' => $products,
                                    'id'=>'product_id',
                                    'options' => [
                                        'required'=>true,
                                        'placeholder' => 'Choose Product ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false) ?>
                            </div>
                                <?php
                            }else{
                                echo $form->field($model, 'prod_id')->hiddenInput(['value'=>$product]);
                            }
                            ?>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Supply</label>
                                <?= $form->field($model, 'supplier_id')->widget(\kartik\select2\Select2::className(),[
                                    'data' => $suppliers,
                                    'options' => [
                                        'required'=>true,
                                        'placeholder' => 'Choose Supplier ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Description (optional)</label>
                                <?= $form->field($model, 'description')->textarea([])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Quantity</label>
                                <?= $form->field($model, 'original_qty')->textInput(['placeholder'=>'Enter quantity', 'type'=>'number', 'required'=>true])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Buying Price (per unit)</label>
                                <?= $form->field($model, 'price_per_unit')->textInput(['placeholder'=>'Enter buying price', 'type'=>'number', 'required'=>true])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    $(document).ready(function() {
        $('#product_id').select2({
            templateResult: formatProduct,
            templateSelection: formatProductSelection,
            escapeMarkup: function (markup) { return markup; }
        });
    });

    function formatProduct(product) {
        if (!product.id) {
            return product.text;
        }
        return $('<span><img src=\"' + product.element.dataset.image + '\" class=\"img-thumbnail\" width=\"50px\" height=\"50px\"> <strong>' + product.text + '</strong> (' + product.element.dataset.quantity + ' in stock)</span>');
    }

    function formatProductSelection(product) {
        return product.text;
    }
", \yii\web\View::POS_READY);
?>







