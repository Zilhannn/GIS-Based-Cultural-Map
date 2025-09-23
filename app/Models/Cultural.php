<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultural extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'history',
        'nowaday',
        'cult_now',
        'location',
        'image',
    ];

    /**
     * Relasi: Satu cultural bisa punya banyak galeri
     */
    public function galleries()
    {
        return $this->hasMany(CulturalGallery::class);
    }
}
