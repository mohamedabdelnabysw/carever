<?php

namespace App\Services;

use App\Models\Trip;

class TripService
{
    public function find($tripId)
    {
        return Trip::find($tripId);
    }
    public function update($data, Trip $trip)
    {
        return $trip->update($data);
    } 
}
