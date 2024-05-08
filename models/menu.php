<?php
namespace app\models;
use rce\material\widgets\Menu as RCEmenu;
use yii\helpers\Url;

class Menu
{
    static function getMenu()
    {
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
//                    [
//                        'label' => 'Farmers',
//                        'icon' => 'people',
//                        'url' => ['/farmers'],
//                        'options'=>['class'=>'nav-item'],
//                    ],
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
//                    [
//                        'label' => 'Products',
//                        'icon' => 'list',
//                        'url' => ['/product'],
//                        'options'=>['class'=>'nav-item'],
//                    ],
//                    [
//                        'label' => 'Pick Up Points',
//                        'icon' => 'map',
//                        'url' => ['/pick-up-points'],
//                        'options'=>['class'=>'nav-item'],
//                    ],
//                    [
//                        'label' => 'Payments',
//                        'icon' => 'payment',
//                        'url' => ['/payment'],
//                        'options'=>['class'=>'nav-item'],
//                    ],
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
        return $menu;
    }

}