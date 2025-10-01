<?php

namespace Database\Seeders;

use App\Models\Protection;
use Illuminate\Database\Seeder;

class ProtectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $protections = [
            ['protection_id' => 'PP000', 'name' => 'none'],
            ['protection_id' => 'PP001', 'name' => 'cover'],
            ['protection_id' => 'PP002', 'name' => 'box'],
        ];

        foreach ($protections as $protection) {
            Protection::firstOrCreate(['protection_id' => $protection['protection_id']], $protection);
        }
    }
}
