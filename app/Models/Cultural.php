<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Cultural
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $category
 * @property string|null $description
 * @property string|null $image
 * @property string|null $video_url
 * @property int|null $has_map
 * @property float|null $latitude
 * @property float|null $longitude
 */
class Cultural extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'history',
        'nowaday',
        'cult_now',
        'location',
        'image',
        'video_url',
        'has_map',
        'longitude',
        'latitude',
    ];

    /**
     * Relasi: Satu cultural bisa punya banyak galeri
     */
    public function galleries()
    {
        return $this->hasMany(CulturalGallery::class, 'cultural_id');
    }

    public function mainImage()
    {
        return $this->hasOne(CulturalGallery::class, 'cultural_id')->oldest();
    }

    public function mapdata()
    {
        return $this->hasOne(CulturalGeodata::class, 'cultural_id');
    }

    /**
     * Generate slug from name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cultural) {
            if (empty($cultural->slug)) {
                $cultural->slug = Str::slug($cultural->name);
            }
        });

        static::updating(function ($cultural) {
            if ($cultural->isDirty('name') || empty($cultural->slug)) {
                $cultural->slug = Str::slug($cultural->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
