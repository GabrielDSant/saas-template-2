<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoHistorico extends Model
{
    use HasFactory;

    protected $table = 'creditos_historico';

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}