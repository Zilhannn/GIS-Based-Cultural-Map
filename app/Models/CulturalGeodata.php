<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CulturalGeodata extends Model
{
    use HasFactory;

    // ✅ sesuaikan nama tabel
    protected $table = 'cultural_mapsdata';

    protected $fillable = [
        'cultural_id',
        'latitude',
        'longitude',
    ];

    public function cultural()
    {
        return $this->belongsTo(Cultural::class, 'cultural_id');
    }
}
