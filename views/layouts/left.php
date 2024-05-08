<?php
use yii\helpers\Html;
use rce\material\widgets\Menu as RCEmenu;

    $menu = $img = "";
    $config = new rce\material\Config();
    $menu = RCEmenu::widget(
    [
        'options'=>[
            'class'=>'nav',
        ],
        'items' => [
            [
                'label' => 'Dashboard',
                'icon' => 'dashboard',
                'url' => ['/site'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Customers',
                'icon' => 'people',
                'url' => ['/customer'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Suppliers',
                'icon' => 'people',
                'url' => ['/supplier'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Employees',
                'icon' => 'people',
                'url' => ['/employee'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Users Management',
                'icon' => 'people',
                'url' => ['/users'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Pick Up Points',
                'icon' => 'map',
                'url' => ['/pick-up-points'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Purchases Report',
                'icon' => 'payment',
                'url' => ['/purchases'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Orders Report',
                'icon' => 'report',
                'url' => ['/order'],
                'options'=>['class'=>'nav-item'],

            ],
            [
                'label' => 'Order Shipment Report',
                'icon' => 'payment',
                'url' => ['/shipping-details'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Products Report',
                'icon' => 'list',
                'url' => ['/product'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Payments Reports',
                'icon' => 'payment',
                'url' => ['/payment'],
                'options'=>['class'=>'nav-item'],
            ],

            [
                'label' => 'Chats History',
                'icon' => 'message',
                'url' => ['/chat'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Feedback',
                'icon' => 'message',
                'url' => ['/feedback'],
                'options'=>['class'=>'nav-item'],
            ],
            [
                'label' => 'Help Center',
                'icon' => 'info',
                'url' => ['/help'],
                'options'=>['class'=>'nav-item'],
            ],

        ],
    ]
);
//    if (class_exists('common\models\Menu')) {
//        // advence template
//        $menu = common\models\Menu::getMenu();
//        // echo $menu;die;
//    }
//    if (class_exists('app\models\Menu')) {
//        // basic template
//        $menu = app\models\Menu::getMenu();
//    }
    if(empty($config::sidebarBackgroundImage())) {
        //$img = $directoryAsset.'/img/background.webp';
    }else {
        $img = $config::sidebarBackgroundImage();
    }
?>
<div class="sidebar" data-color="<?= $config::sidebarColor()  ?>" data-background-color="<?= $config::sidebarBackgroundColor()  ?>">
    <div class="logo">
        <a href="#" class="simple-text logo-mini ">
            <?php
            if(empty($config::logoMini())) { ?>
                <img src="<?=$directoryAsset;?>/img/midland.png" style="max-width: 60px;">
            <?php } else {
                echo $config::logoMini();
            }
            ?>
        </a>
        <a href="#" class="simple-text logo-normal ">
            <?= $config::siteTitle()  ?>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <?= $menu ?>
    </div>
    <div class="sidebar-background" style="background-image: url(<?= $img ?>) "></div>
</div>
