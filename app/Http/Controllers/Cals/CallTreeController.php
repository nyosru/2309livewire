<?php

namespace App\Http\Controllers\Cals;

use App\Http\Controllers\Controller;
use App\Models\Cals\Call;
use App\Models\Cals\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CallTreeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $contacts = Contact::query()
            ->with(['calls' => fn ($query) => $query->orderBy('call_at')->orderBy('id')])
            ->withCount('calls')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('calls', fn ($calls) => $calls->where('is_deleted', false)->where('summary', 'like', "%{$search}%"));
            }))
            ->orderByRaw('(select min(call_at) from cals_calls where cals_calls.contact_id = cals_contacts.id) is null')
            ->orderByRaw('(select min(call_at) from cals_calls where cals_calls.contact_id = cals_contacts.id) asc')
            ->get();

        $unassignedCalls = Call::query()
            ->whereNull('contact_id')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('phone', 'like', "%{$search}%")
                    ->orWhere(fn ($calls) => $calls->where('is_deleted', false)->where('summary', 'like', "%{$search}%"));
            }))
            ->orderBy('call_at')
            ->get();

        return view('cals.index', compact('contacts', 'unassignedCalls', 'search'));
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:64'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);
        $data['phone_normalized'] = $this->normalizePhone($data['phone'] ?? null);

        if ($data['phone_normalized']) {
            $existing = Contact::where('phone_normalized', $data['phone_normalized'])->first();
            if ($existing) {
                $existing->update([
                    'name' => $data['name'] ?: $existing->name,
                    'notes' => $data['notes'] ?: $existing->notes,
                    'company_name' => $data['company_name'] ?: $existing->company_name,
                    'start_date' => $data['start_date'] ?: $existing->start_date,
                ]);

                return redirect()->route('cals.contacts.show', $existing)->with('status', 'Уже существующий контакт открыт.');
            }
        }

        $contact = Contact::create($data);

        return redirect()->route('cals.contacts.show', $contact)->with('status', 'Контакт создан.');
    }

    public function showContact(Contact $contact): View
    {
        $contact->load(['calls', 'comments']);

        return view('cals.contact', compact('contact'));
    }

    public function updateContact(Request $request, Contact $contact): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:64'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);
        $data['phone_normalized'] = $this->normalizePhone($data['phone'] ?? null);
        $request->validate([
            'phone' => ['nullable', function ($attribute, $value, $fail) use ($contact, $data) {
                if ($data['phone_normalized'] && Contact::where('phone_normalized', $data['phone_normalized'])->where('id', '!=', $contact->id)->exists()) {
                    $fail('Этот номер уже привязан к другому контакту.');
                }
            }],
        ]);
        $contact->update($data);

        return redirect()->route('cals.contacts.show', $contact)->with('status', 'Данные контакта сохранены.');
    }

    public function storeComment(Request $request, Contact $contact): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:10000']]);
        $contact->comments()->create($data);

        return redirect()->route('cals.contacts.show', $contact)->with('status', 'Комментарий добавлен.');
    }

    public function storeCall(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'contact_id' => ['nullable', 'integer', 'exists:cals_contacts,id'],
            'phone' => ['nullable', 'string', 'max:64'],
            'call_at' => ['required', 'date'],
            'summary' => ['nullable', 'string', 'max:10000'],
            'transcript' => ['nullable', 'string', 'max:1000000'],
        ]);
        $contact = isset($data['contact_id']) ? Contact::find($data['contact_id']) : null;
        $phone = $data['phone'] ?? $contact?->phone;
        if (! $contact && ($normalized = $this->normalizePhone($phone))) {
            $contact = Contact::firstOrCreate(
                ['phone_normalized' => $normalized],
                ['phone' => $phone]
            );
        }

        Call::create([
            'contact_id' => $contact?->id,
            'phone' => $phone,
            'call_at' => $data['call_at'],
            'summary' => $data['summary'] ?? null,
            'transcript' => $data['transcript'] ?? null,
        ]);

        return redirect()->route('cals.index')->with('status', 'Звонок добавлен в хронологию.');
    }

    public function attachCalls(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'contact_id' => ['required', 'integer', 'exists:cals_contacts,id'],
            'call_ids' => ['required', 'array', 'min:1'],
            'call_ids.*' => ['required', 'integer', 'exists:cals_calls,id'],
        ]);

        $updated = Call::whereIn('id', $data['call_ids'])
            ->whereNull('contact_id')
            ->where('is_deleted', false)
            ->update(['contact_id' => $data['contact_id']]);

        return redirect()->route('cals.index')->with('status', "К контакту привязано звонков: {$updated}.");
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 10) {
            return '7'.$digits;
        }
        if (strlen($digits) === 11 && $digits[0] === '8') {
            return '7'.substr($digits, 1);
        }

        return strlen($digits) >= 10 ? $digits : null;
    }
}
