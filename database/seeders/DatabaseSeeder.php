<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Station::factory(20)->create();
        \App\Models\BusType::insert([
            ['name'=> "long"],
            ['name'=> "short"],
        ]);
        $types = \App\Models\BusType::all();
        \App\Models\Bus::factory(1)->create([
            'seats_count' => 20,
            'bus_type_id' => $types->first()->id
        ]);
        \App\Models\Bus::factory(1)->create([
            'seats_count' => 20,
            'bus_type_id' => $types->last()->id
        ]);
        $this->call([
            TripSeeder::class
        ]);
    }
}
