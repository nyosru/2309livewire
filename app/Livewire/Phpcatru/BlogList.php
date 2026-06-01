<?php

namespace App\Livewire\Phpcatru;

use Livewire\Component;

class BlogList extends Component
{
    public $posts = [
        [
            'slug' => 'kak-ii-mozhet-pomoch-malomu-biznesu',
            'title' => 'Как ИИ может помочь малому бизнесу: 5 реальных сценариев',
            'excerpt' => 'Разбираем конкретные примеры использования нейросетей в небольшом бизнесе — от генерации контента до анализа данных.',
            'date' => '1 июня 2026',
            'tag' => 'Статья',
            'image' => null,
        ],
        [
            'slug' => 'chto-takoe-lokalnyy-ii-i-zachem-on-nuzhen',
            'title' => 'Что такое локальный ИИ и зачем он нужен вашему бизнесу',
            'excerpt' => 'Объясняем, чем отличаются облачные и локальные модели, и в каких случаях локальный ИИ — единственно верное решение.',
            'date' => '25 мая 2026',
            'tag' => 'Обзор',
            'image' => null,
        ],
        [
            'slug' => 'besplatnye-ii-modeli-2026',
            'title' => 'Топ-10 бесплатных ИИ-моделей 2026 года',
            'excerpt' => 'Подборка лучших open-source моделей, которые не уступают платным аналогам. Полностью бесплатно и без ограничений.',
            'date' => '18 мая 2026',
            'tag' => 'Подборка',
            'image' => null,
        ],
        [
            'slug' => 'audit-bezopasnosti-seti',
            'title' => 'Почему аудит безопасности сети — это не расходы, а инвестиция',
            'excerpt' => 'Рассказываем на реальных примерах, как одна найденная уязвимость может сэкономить миллионы.',
            'date' => '10 мая 2026',
            'tag' => 'Статья',
            'image' => null,
        ],
        [
            'slug' => 'ii-v-buhgalterii',
            'title' => 'ИИ в бухгалтерии: как автоматизировать рутину за 1 день',
            'excerpt' => 'Пошаговое руководство по внедрению ИИ в работу бухгалтера. Реальные кейсы и цифры экономии времени.',
            'date' => '3 мая 2026',
            'tag' => 'Гайд',
            'image' => null,
        ],
    ];

    public function render()
    {
        return view('livewire.phpcatru.blog-list')
            ->layout('livewire.phpcatru.layouts.app-component', [
                'title' => 'Блог об ИИ — php-cat.ru'
            ]);
    }
}
