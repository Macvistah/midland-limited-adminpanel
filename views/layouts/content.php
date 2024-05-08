<?php
use yii\helpers\Html;
use rce\material\widgets\Noti;
use rce\material\Assets;
    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        rce\material\Assets::register($this);
        //app\assets\AppAsset::register($this);
    }
    $bundle = Assets::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/ricar2ce/yii2-material-theme/assets');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>

            .file_input_div {
                margin: auto;
                width: 100%;
                height: auto;
            }
            .product_img{
                max-width: 40%;
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            .file_input {
                float: left;
            }

            #file_input_text_div {
                width:100%;
                margin-left: 5px;
            }

            .none {
                display: none;
            }
        </style>
    </head>
    <body class="perfect-scrollbar-on ">
    <?php $this->beginBody() ?>
    <div class="wrapper ">
        <div class="">

            <div class="">
                <div class="container-fluid">
                    <?= Noti::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>

