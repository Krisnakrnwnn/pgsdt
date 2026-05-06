<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'itinerary',
        'event_date',
        'location',
        'location_map',
        'image_path',
        'status',
        'registration_enabled',
        'is_featured',
        'quota',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_enabled' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function registrations()
    {
        return $this->hasMany(AgendaRegistration::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
                     ->where('event_date', '>=', now())
                     ->orderBy('event_date', 'asc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getAvailableSlotsAttribute()
    {
        if (!$this->quota) {
            return null;
        }
        return $this->quota - $this->registrations()->confirmed()->count();
    }

    public function isFullyBooked()
    {
        if (!$this->quota) {
            return false;
        }
        return $this->available_slots <= 0;
    }
}
