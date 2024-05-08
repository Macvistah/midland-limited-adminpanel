<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Help */

$this->title = 'Update FAQ';
$this->params['breadcrumbs'][] = ['label' => 'Helps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="help-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
