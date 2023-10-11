<?php

namespace App\Models\Uprav;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backword extends Model
{
    use HasFactory;
    protected $table = 'uprav_backwords';
    protected $fillable = ['names', 'contact','message'];

}
