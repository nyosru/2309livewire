<?php

return [
    'timezone' => 'Asia/Yekaterinburg',
    'phone' => env('VKUSNO_PHONE') ?: '+7 (963) 452-17-13',
    'address' => env('VKUSNO_ADDRESS') ?: 'Тюмень, Харьковская улица, 59а, 1 этаж',
    'hours' => env('VKUSNO_HOURS') ?: 'Ежедневно с 08:30 до 21:00',
    'map_url' => 'https://2gis.ru/tyumen/firm/70000001045708211',
    'directions_url' => 'https://2gis.ru/tyumen/directions/points/%7C65.584612%2C57.149141%3B70000001045708211',
    'photos_url' => 'https://2gis.ru/tyumen/gallery/firm/70000001045708211',
    'seats' => 80,
    'demo_menu' => env('VKUSNO_DEMO_MENU', true),
    // Null means the delivery cost must be confirmed by the cafe.
    'delivery_fee' => env('VKUSNO_DELIVERY_FEE'),
    'cake_lead_days' => 3,
    'products' => [
        ['id' => 'breakfast', 'name' => 'Завтрак без спешки', 'category' => 'breakfast', 'label' => 'Завтраки', 'description' => 'Глазунья, хрустящие тосты и овощи', 'weight' => '320 г', 'price' => 390, 'image' => 'breakfast.jpg', 'badge' => 'Доброе утро'],
        ['id' => 'pasta', 'name' => 'Паста с песто', 'category' => 'hot', 'label' => 'Горячее', 'description' => 'Базиликовый песто, томаты и пармезан', 'weight' => '300 г', 'price' => 450, 'image' => 'pasta.jpg', 'badge' => 'Сытно и вкусно'],
        ['id' => 'salad', 'name' => 'Салат с овощами', 'category' => 'salads', 'label' => 'Салаты', 'description' => 'Свежие овощи, фета и ароматная заправка', 'weight' => '250 г', 'price' => 340, 'image' => 'salad.jpg', 'badge' => 'Что-то лёгкое'],
        ['id' => 'cheesecake', 'name' => 'Чизкейк с ягодами', 'category' => 'desserts', 'label' => 'Десерты', 'description' => 'Нежная сливочная начинка на песочной основе', 'weight' => '150 г', 'price' => 290, 'image' => 'cheesecake.jpg', 'badge' => 'К чаю'],
        ['id' => 'coffee', 'name' => 'Капучино', 'category' => 'drinks', 'label' => 'Напитки', 'description' => 'Эспрессо и воздушная молочная пенка', 'weight' => '250 мл', 'price' => 190, 'image' => 'coffee.jpg', 'badge' => 'Маленькая радость'],
    ],
    'fillings' => ['Молочная девочка', 'Шоколадная вишня', 'Красный бархат', 'Ваниль и ягоды'],
];
