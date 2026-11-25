<?php

namespace App\Livewire\Phpcat\Services;

use App\Services\Checko\CheckoService;
use App\Services\VkNotifierService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use RuntimeException;

class Checko extends Component
{
    public string $target = 'company_inn';

    public string $number = '';

    public ?array $result = null;

    public ?string $error = null;

    public ?string $queryLabel = null;

    public function updatedTarget(): void
    {
        $this->result = null;
        $this->error = null;
        $this->resetErrorBag('number');
    }

    public function search(CheckoService $checko): void
    {
        $this->result = null;
        $this->error = null;
        $this->queryLabel = null;
        $this->resetErrorBag();

        $definition = CheckoService::target($this->target);

        if ($definition === null) {
            $this->error = 'Выберите, что нужно найти.';

            return;
        }

        $this->validate([
            'number' => ['required', 'digits:'.$definition['digits']],
        ], [
            'number.required' => 'Введите номер.',
            'number.digits' => 'Нужно ровно '.$definition['digits'].' цифр без пробелов.',
        ]);

        $rateLimitKey = 'phpcat-checko:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $this->error = 'Слишком много запросов. Попробуйте через '.RateLimiter::availableIn($rateLimitKey).' с.';

            return;
        }

        RateLimiter::hit($rateLimitKey, 60);

        try {
            $this->result = $checko->lookup($this->target, $this->number);
            $this->queryLabel = $definition['label'].': '.$this->number;

            $this->notifyVk($definition['label']);
        } catch (RuntimeException $exception) {
            $this->error = $exception->getMessage();
        }
    }

    private function notifyVk(string $label): void
    {
        $token = (string) config('services.checko.vk_token');
        $userId = (string) config('services.checko.vk_user_id', '5903492');

        if ($token === '' || $userId === '') {
            return;
        }

        $lines = [$label.': '.$this->number];

        foreach ($this->summary() as $key => $value) {
            $lines[] = $key.': '.$value;
        }

        $json = json_encode($this->result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if (is_string($json) && $json !== '') {
            $json = mb_substr($json, 0, 1500);
            $lines[] = '';
            $lines[] = 'Ответ API: '.$json;
        }

        $message = implode("\n", $lines);

        try {
            app(VkNotifierService::class)->send($message, $userId, 5, $token);
        } catch (\Throwable $exception) {
            Log::warning('Checko VK notification failed', [
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.phpcat.services.checko', [
            'targets' => CheckoService::targets(),
        ]);
    }

    /**
     * Короткая сводка ответа для отображения на странице.
     *
     * @return array<string, string>
     */
    public function summary(): array
    {
        $data = $this->result['data'] ?? null;

        if (! is_array($data)) {
            return [];
        }

        $rows = [];

        $add = static function (string $label, mixed $value) use (&$rows): void {
            if (is_scalar($value) && trim((string) $value) !== '') {
                $rows[$label] = (string) $value;
            }
        };

        if (isset($data['НаимПолн']) || isset($data['НаимСокр'])) {
            $add('Наименование', $data['НаимПолн'] ?? $data['НаимСокр'] ?? null);
            $add('ИНН', $data['ИНН'] ?? null);
            $add('КПП', $data['КПП'] ?? null);
            $add('ОГРН', $data['ОГРН'] ?? null);
            $add('Статус', is_array($data['Статус'] ?? null) ? ($data['Статус']['Наим'] ?? null) : null);
            $add('Дата регистрации', $data['ДатаРег'] ?? null);
            $add('Регион', is_array($data['Регион'] ?? null) ? ($data['Регион']['Наим'] ?? null) : null);
            $add('Юридический адрес', is_array($data['ЮрАдрес'] ?? null) ? ($data['ЮрАдрес']['АдресРФ'] ?? null) : null);

            $okved = is_array($data['ОКВЭД'] ?? null) ? $data['ОКВЭД'] : [];
            $okvedText = trim(($okved['Код'] ?? '').' '.($okved['Наим'] ?? ''));
            $add('Основной ОКВЭД', $okvedText);

            $leader = is_array($data['Руковод'] ?? null) ? ($data['Руковод'][0] ?? null) : null;
            if (is_array($leader)) {
                $leaderText = trim(($leader['НаимДолжн'] ?? '').' '.($leader['ФИО'] ?? ''));
                $add('Руководитель', $leaderText);
            }

            $phones = is_array($data['Контакты'] ?? null) ? ($data['Контакты']['Тел'] ?? []) : [];
            $add('Телефон', is_array($phones) ? implode(', ', $phones) : null);
            $add('Сайт', is_array($data['Контакты'] ?? null) ? ($data['Контакты']['ВебСайт'] ?? null) : null);
        } else {
            $add('ФИО', $data['ФИО'] ?? null);
            $add('ИНН', $data['ИНН'] ?? null);
            $add('ОГРНИП', $data['ОГРНИП'] ?? null);
            $add('Статус', is_array($data['Статус'] ?? null) ? ($data['Статус']['Наим'] ?? null) : null);
            $add('Дата регистрации', $data['ДатаРег'] ?? null);
            $add('Регион', is_array($data['Регион'] ?? null) ? ($data['Регион']['Наим'] ?? null) : null);
            $add('Населённый пункт', $data['НасПункт'] ?? null);

            $okved = is_array($data['ОКВЭД'] ?? null) ? $data['ОКВЭД'] : [];
            $okvedText = trim(($okved['Код'] ?? '').' '.($okved['Наим'] ?? ''));
            $add('Основной ОКВЭД', $okvedText);

            $stop = is_array($data['Прекращ'] ?? null) ? ($data['Прекращ']['Дата'] ?? null) : null;
            $add('Дата прекращения деятельности', $stop);
        }

        return $rows;
    }
}
