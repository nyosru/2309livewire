<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectHit extends Model
{
    protected $fillable = ['redirect_id', 'ip_address', 'hit_at'];

    public $timestamps = false;

    // Связь с моделью Redirect
    public function redirect()
    {
        return $this->belongsTo(Redirect::class);
    }
}
