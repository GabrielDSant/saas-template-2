<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_image_path',
        'generated_image_path',
        'style',
        'status',
        'error_message',
    ];
}