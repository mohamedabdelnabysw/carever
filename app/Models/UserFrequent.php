<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFrequent extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function fromStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'from_station_id', 'id');
    }
    public function toStation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'to_station_id', 'id');
    }
}
