<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comment',
        'ar_object_id',
        'ar_people_id',
    ];

    // Связь с ArObject
    public function object()
    {
        return $this->belongsTo(ArObject::class, 'ar_object_id');
    }

    // Связь с ArPeople (арендатором)
    public function people()
    {
        return $this->belongsTo(ArPeople::class, 'ar_people_id');
    }
}
