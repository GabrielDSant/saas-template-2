<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
