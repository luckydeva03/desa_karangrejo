<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'images', 'category', 'type', 'status'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getThumbnailAttribute(): ?string
    {
        $images = $this->images;
        if (!empty($images) && is_array($images)) {
            $firstFile = $images[0];
            
            // For video files, we'll show the video file itself for HTML5 video thumbnail
            if ($this->type === 'video') {
                return asset('storage/' . $firstFile);
            }
            
            // For photos
            return asset('storage/' . $firstFile);
        }
        
        // Default thumbnail based on type
        if ($this->type === 'video') {
            return asset('images/default-video.svg');
        }
        
        return asset('images/default-gallery.jpg');
    }
    
    public function getVideoUrlAttribute(): ?string
    {
        if ($this->type === 'video' && !empty($this->images) && is_array($this->images)) {
            return asset('storage/' . $this->images[0]);
        }
        return null;
    }
}