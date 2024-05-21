<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Payment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'amount',
        'date',
        'photo',
        'note',
        'student_id', 
        'verified',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected $keyType = 'string';
    public $incrementing = false;
}
