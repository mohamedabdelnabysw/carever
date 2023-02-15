<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bus = Bus::with('seats')->get()->first();
        for ($i = 0; $i <= 18; $i+=2) {
            $stations = Station::skip(5)->limit(2)->get();
            $trip = Trip::create([
                'from_station_id' => $stations->first()->id,
                'to_station_id' => $stations->last()->id,
                'bus_id' => $bus->id
            ]);
            Ticket::create([
                'seat_id' => $bus->seats->first()->id,
                'trip_id' => $trip->id,
                'user_id' => 1
            ]);
        }
    }
}
