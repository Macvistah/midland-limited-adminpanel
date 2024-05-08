<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShippingDetails */

$this->title = Yii::t('app', 'Create Shipping Details');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shipping Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
