<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeComponentOrder extends Model
{
    /** @use HasFactory<\Database\Factories\HomeComponentOrderFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'home_components_order';

    protected $fillable = [
        'layout_id',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    /**
     * Get the home layout that owns this component order
     */
    public function homeLayout(): BelongsTo
    {
        return $this->belongsTo(HomeComponents::class, 'layout_id', 'id');
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
