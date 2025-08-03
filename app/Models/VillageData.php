<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageData extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'type_id', 'label', 'value', 'description', 'icon', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    // Relationships
    public function dataType()
    {
        return $this->belongsTo(VillageDataType::class, 'type_id');
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Accessors
    public function getTypeNameAttribute()
    {
        return ucfirst($this->type);
    }
}