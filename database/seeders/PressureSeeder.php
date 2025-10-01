<?php

namespace Database\Seeders;

use App\Models\Pressure;
use Illuminate\Database\Seeder;

class PressureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pressures = [
            ['pressure_id' => 'PR001', 'name' => 'permanent pressure'],
            ['pressure_id' => 'PR002', 'name' => 'auxiliary pressure'],
        ];

        foreach ($pressures as $pressure) {
            Pressure::firstOrCreate(['pressure_id' => $pressure['pressure_id']], $pressure);
        }
    }
}
