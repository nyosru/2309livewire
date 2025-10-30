<?php

namespace App\Livewire\Phpcatcom\Datar2\Admin;

use Livewire\Component;
use App\Models\DatarParent;
use Illuminate\Support\Facades\Log;
use Barryvdh\Debugbar\Facades\Debugbar;

class DatarParentEdit extends Component
{
    public ?DatarParent $datarParent = null;

    public $title = '';
    public $content = '';
    public $order = 0;
    public $is_active = false;
    public $id;
    public $action_name;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'order' => 'required|integer',
        'is_active' => 'boolean|nullable',
    ];

    public $layout = '';

    public function mount($id = null)
    {
        Log::info('[DatarParentEdit] mount вызван', ['id' => $id]);
        $this->layout = 'livewire.cfa.app.body';

        if ($id) {
            try {
                $this->datarParent = DatarParent::findOrFail($id);

                $this->title = $this->datarParent->title;
                $this->content = $this->datarParent->content;
                $this->order = $this->datarParent->order;
                $this->is_active = $this->datarParent->is_active;

                Log::info('[DatarParentEdit] Редактирование существующей записи', [
                    'id' => $this->datarParent->id,
                    'title' => $this->title,
                ]);
                Debugbar::info('Загружена запись DatarParent', $this->datarParent);
                $this->action_name = 'Редактируем';
            } catch (\Exception $e) {
                Log::warning('[DatarParentEdit] Ошибка загрузки, создаём новую запись', [
                    'id' => $id,
                    'error' => $e->getMessage(),
                ]);
                $this->datarParent = null;

            }
        } else {
            $this->datarParent = null;
            Log::info('[DatarParentEdit] Создание новой записи');
            $this->action_name = 'Создаём';
        }
    }

    public function save()
    {
        $this->validate();

        Log::info('[DatarParentEdit] Сохранение', [
            'title' => $this->title,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ]);

        try {
            // ✅ универсальное сохранение
            $record = DatarParent::updateOrCreate(
                ['id' => $this->datarParent->id ?? null],
                [
                    'title' => $this->title,
                    'content' => $this->content,
                    'order' => $this->order,
                    'is_active' => $this->is_active,
                ]
            );

            Log::info('[DatarParentEdit] Запись успешно сохранена', ['id' => $record->id]);
            Debugbar::success('Запись сохранена', $record);

            session()->flash('parent_success', 'Группа изменена.');
            return redirect()->route('tech.datar2');

        } catch (\Exception $e) {
            Log::error('[DatarParentEdit] Ошибка при сохранении', ['error' => $e->getMessage()]);
            Debugbar::error('Ошибка при сохранении', $e);
            session()->flash('parent_error', 'Ошибка при сохранении: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $view = view('livewire.phpcatcom.datar2.admin.datar-parent-edit');
        return $this->layout ? $view->layout($this->layout) : $view;
    }
}
