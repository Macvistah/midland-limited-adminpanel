<?php
;

/* @var $this yii\web\View */
/* @var $model app\models\PickUpPoints */

$this->title = 'Update Pick Up Points';
$this->params['breadcrumbs'][] = ['label' => 'Pick Up Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pick-up-points-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
