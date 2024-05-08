<?php
$modelTitles = \app\models\HelpTitle::find()->all();
if (isset($_GET["user"])){
    $user_type = $_GET['user'];

}
?>
<div class="help-faq">
    <div class="row">

        <?php
        if (count($modelTitles)>0){
            foreach ($modelTitles as $modelTitle){
        ?>
            <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title"><?= $modelTitle->title?></h4>
                </div>
                <div class="card-body">
                    <?php

                    $modelFaqs = \app\models\Help::find()
                    ->orFilterWhere(['=','user_type',$user_type])
                    ->orFilterWhere(['=','user_type','all'])
                    ->andFilterWhere(['=','title_id',$modelTitle->id])
                    ->all();
                    if (count($modelFaqs)>0){
                        $i = 1;
                        foreach ($modelFaqs as $modelFaq){
                    ?>
                        <span><?= $i?>. <strong><?=$modelFaq->question?></strong> <?= $modelFaq->answer?> </span>
                        <hr>
                    <?php
                            $i++;
                        }
                    }else{
                        echo "No question found!<hr>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div>
</div>