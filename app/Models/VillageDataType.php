<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VillageDataType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'icon', 
        'color', 
        'sort_order', 
        'is_active'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean'
    ];

        // Relationships
    public function villageData()
    {
        return $this->hasMany(VillageData::class, 'type_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Accessors
    public function getBadgeClassAttribute()
    {
        return "badge bg-{$this->color}";
    }

    public function getVillageDataCountAttribute()
    {
        return $this->villageData()->count();
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Methods
    public static function getNextSortOrder()
    {
        return static::max('sort_order') + 1;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
