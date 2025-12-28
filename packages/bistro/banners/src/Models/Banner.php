<?php

namespace Bistro\Banners\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'mobile_image_path',
        'button_text',
        'button_url',
        'is_active',
        'sort_order',
        'position',
        'starts_at',
        'ends_at',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePosition(Builder $query, string $position): Builder
    {
        return $query->where('position', $position);
    }

    public function scopeCurrentlyActive(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', now());
        })->where(function (Builder $query) {
            $query->whereNull('ends_at')
                  ->orWhere('ends_at', '>= now');
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        return $this->mobile_image_path ? asset('storage/' . $this->mobile_image_path) : null;
    }

    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && $this->starts_at > now()) {
            return false;
        }

        if ($this->ends_at && $this->ends_at < now()) {
            return false;
        }

        return true;
    }
}
