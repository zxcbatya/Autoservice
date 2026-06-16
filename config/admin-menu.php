<?php

return [

    [
        'text' => 'Главная',
        'icon' => 'fas fa-fw fa-tachometer-alt',
        'route' => 'admin.dashboard',
    ],
    [
        'text' => 'Автосервис',
        'icon' => 'fas fa-fw fa-car',
        'route_prefix' => 'admin.sto.',
        'submenu' => [
            ['text' => 'Заказы', 'route' => 'admin.sto.orders.index', 'icon' => 'fa-clipboard-list'],
            ['text' => 'Мастера', 'route' => 'admin.sto.workers.index', 'icon' => 'fa-user-cog'],
            ['text' => 'Клиенты', 'route' => 'admin.sto.clients.index', 'icon' => 'fa-users'],
            ['text' => 'Расходы', 'route' => 'admin.sto.expenses.index', 'icon' => 'fa-wallet'],
            ['text' => 'Зарплаты', 'route' => 'admin.sto.payments.index', 'icon' => 'fa-money-bill-wave'],
            ['text' => 'Отчёты', 'route' => 'admin.sto.reports.index', 'icon' => 'fa-chart-bar'],
            ['text' => 'Запчасти', 'route' => 'admin.sto.parts.index', 'icon' => 'fa-cogs'],
        ],
    ],
    [
        'text' => 'Ключевые услуги',
        'route' => 'admin.service.index',
        'icon' => 'fa-fw fa-wrench',
    ],
    [
        'text' => 'Отзывы',
        'route' => 'admin.review.index',
        'icon' => 'fa-fw fa-star',
    ],
];
