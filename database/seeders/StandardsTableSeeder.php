<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standards = [
            [
                'name' => 'NFPA 10',
                'description' => 'Provides requirements to ensure that portable fire extinguishers will work as intended to provide a first line of defense against fires of limited size.',
                'version' => '2018',
            ],
            [
                'name' => 'NFPA 13',
                'description' => 'Specifies the minimum requirements for the design and installation of automatic fire sprinkler systems.',
                'version' => '2019',
            ],
            [
                'name' => 'NFPA 25',
                'description' => 'Establishes the minimum requirements for the periodic inspection, testing, and maintenance of water-based fire protection systems.',
                'version' => '2020',
            ],
            [
                'name' => 'NFPA 72',
                'description' => 'Covers the installation, performance, testing, and maintenance of fire alarm systems.',
                'version' => '2019',
            ],
            [
                'name' => 'NFPA 2001',
                'description' => 'Provides requirements for the design, installation, testing, and maintenance of clean agent fire extinguishing systems.',
                'version' => '2018',
            ],
            [
                'name' => 'ISO 14520',
                'description' => 'Provides guidelines for the design, installation, and maintenance of gaseous fire-extinguishing systems.',
                'version' => '2015',
            ],
            [
                'name' => 'EN 3',
                'description' => 'European standard that specifies the requirements for the construction, performance, and testing of portable fire extinguishers.',
                'version' => '2007',
            ],
            [
                'name' => 'BS 5306',
                'description' => 'Provides recommendations for the installation and maintenance of fire extinguishing equipment.',
                'version' => '2018',
            ],
            [
                'name' => 'UL 300',
                'description' => 'Specifies fire testing requirements for fire extinguishing systems designed for commercial cooking equipment.',
                'version' => '2018',
            ],
            [
                'name' => 'NFPA 11',
                'description' => 'Provides requirements for the design, installation, and maintenance of foam fire-extinguishing systems.',
                'version' => '2021',
            ],
            [
                'name' => 'APSAD R4',
                'description' => 'French standard for the installation and maintenance of fire detection and alarm systems.',
                'version' => '2017',
            ],
            [
                'name' => 'APSAD R5',
                'description' => 'French standard for the design, installation, and maintenance of sprinkler systems.',
                'version' => '2018',
            ],
            [
                'name' => 'NOCPT 123',
                'description' => 'National standard for fire safety requirements in Tunisia, issued by the National Office for Civil Protection.',
                'version' => '2020',
            ],
        ];

        foreach ($standards as $index => $standard) {
            DB::table('standards')->insert([
                'standard_id' => 'SR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'name' => $standard['name'],
                'description' => $standard['description'],
                'version' => $standard['version'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
