<?php

namespace App\Models\Max;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $table = 'max_recipients';

    protected $fillable = ['phone', 'max_user_id'];

    protected $hidden = ['phone'];
}
