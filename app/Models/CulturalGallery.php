<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalGallery extends Model
{
    use HasFactory;

    protected $fillable = ['cultural_id', 'image_path'];

    public function cultural()
    {
        return $this->belongsTo(Cultural::class);
    }
}
