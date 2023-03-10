<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    public function fromStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'from_station_id', 'id');
    }
    public function toStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'to_station_id', 'id');
    }
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

}
