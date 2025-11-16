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
        return $this->belongsTo(Cultural::class, 'cultural_id');
    }

    // Akses URL gambar siap pakai
    public function getImageUrlAttribute()
    {
        // Pastikan file benar-benar ada di public/storage/
        $path = public_path('storage/' . $this->image_path);

        if ($this->image_path && file_exists($path)) {
            return asset('storage/' . $this->image_path);
        }

        // fallback jika tidak ada gambar
        return asset('images/no-image.png');
    }
}
