<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
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
        $bus = Bus::all()->first();
        for ($i = 0; $i <= 18; $i+=2) {
            $stations = Station::skip($i)->limit(4)->get();
            Trip::create([
                'from_station_id' => $stations->first()->id,
                'to_station_id' => $stations->last()->id,
                'bus_id' => $bus->id
            ]);
        }
    }
}
