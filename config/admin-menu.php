<?php

return [

    [
        'text' => 'Главная',
        'icon' => 'fas fa-fw fa-home',
        'route' => '/',
    ],
    [
        'text' => 'Пользователи',
        'route' => 'backend.user.index',
        'icon' => 'fa-fw fa-user',
    ],
    [
        'text' => 'Страницы',
        'route' => 'backend.page.index',
        'icon' => 'fa-fw fa-bars',
    ],
    [
        'text'=>'Ключевые услуги',
        'route'=>'admin.service.index',
        'icon' =>'fa-fw fa-wrench',
    ],
    [
        'text' => 'Отзывы',
        'route' => 'admin.review.index',
        'icon' => 'fa-fw fa-star',
    ],
];
