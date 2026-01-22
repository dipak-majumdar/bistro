<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomeComponents extends Model
{
    /** @use HasFactory<\Database\Factories\HomeComponentsFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'component',
        'is_active'
    ];

    protected $casts = [
        'component' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * Get the component orders for this layout
     */
    public function componentOrders(): HasMany
    {
        return $this->hasMany(HomeComponentOrder::class, 'layout_id', 'id');
    }

    /**
     * Get components in order
     */
    public static function getOrderedComponents(): array
    {
        return self::active()->get()->componentOrders()
            ->orderBy('sort_order')
            ->pluck('component_id')
            ->toArray();
    }

    /**
     * Set components in specific order
     */
    public function setComponents(array $components): self
    {
        // Delete existing component orders
        $this->componentOrders()->delete();
        
        // Create new component orders
        foreach ($components as $index => $componentId) {
            $this->componentOrders()->create([
                'component_id' => $componentId,
                'sort_order' => $index
            ]);
        }
        
        return $this;
    }

    /**
     * Add component to layout
     */
    public function addComponent(string $componentId, int $position = null): self
    {
        if ($position !== null) {
            // Update existing components to make space
            $this->componentOrders()
                ->where('sort_order', '>=', $position)
                ->increment('sort_order');
        }

        $this->componentOrders()->create([
            'component_id' => $componentId,
            'sort_order' => $position ?? $this->componentOrders()->max('sort_order') + 1
        ]);

        return $this;
    }

    /**
     * Remove component from layout
     */
    public function removeComponent(string $componentId): self
    {
        $componentOrder = $this->componentOrders()
            ->where('component_id', $componentId)
            ->first();

        if ($componentOrder) {
            $componentOrder->delete();
            
            // Update sort orders of remaining components
            $this->componentOrders()
                ->where('sort_order', '>', $componentOrder->sort_order)
                ->decrement('sort_order');
        }

        return $this;
    }

    /**
     * Reorder components
     */
    public function reorderComponents(array $newOrder): self
    {
        // Delete existing orders
        $this->componentOrders()->delete();
        
        // Create new orders
        foreach ($newOrder as $index => $componentId) {
            $this->componentOrders()->create([
                'component_id' => $componentId,
                'sort_order' => $index
            ]);
        }

        return $this;
    }

    /**
     * Check if component exists in layout
     */
    public function hasComponent(string $componentId): bool
    {
        return $this->componentOrders()
            ->where('component_id', $componentId)
            ->exists();
    }

    /**
     * Scope to get only active layouts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by component order
     */
    public function scopeOrdered($query)
    {
        return $query->with(['componentOrders' => function($query) {
            $query->orderBy('sort_order');
        }]);
    }

    /**
     * Get active layouts ordered by component order
     */
    public static function getActive()
    {
        return self::active()->get();
    }

    /**
     * Get current active layout
     */
    public static function getCurrent()
    {
        return self::active()->first();
    }
}
