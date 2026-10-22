<?php

namespace App\Models\Vkusno;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhoneAdministrator extends Model
{
    protected $table = 'vkusno_phone_administrators';

    protected $fillable = ['phone', 'name', 'granted_by_user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
