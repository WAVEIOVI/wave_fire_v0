<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_id' => 'MS001',
                'name' => 'Fire Extinguisher Inspection',
                'description' => 'Comprehensive inspection and maintenance of various types of fire extinguishers.'
            ],
            [
                'service_id' => 'MS002',
                'name' => 'Fire Alarm System Testing',
                'description' => 'Testing and servicing of fire alarm systems to ensure proper functionality.'
            ],
            [
                'service_id' => 'MS003',
                'name' => 'Sprinkler System Maintenance',
                'description' => 'Inspection and maintenance of automatic sprinkler systems.'
            ],
            [
                'service_id' => 'MS004',
                'name' => 'Fire Hose Reel Testing',
                'description' => 'Testing and maintenance of fire hose reels for optimal performance.'
            ],
            [
                'service_id' => 'MS005',
                'name' => 'Emergency Lighting Check',
                'description' => 'Inspection and testing of emergency lighting systems.'
            ],
            [
                'service_id' => 'MS006',
                'name' => 'Fire Door Inspection',
                'description' => 'Inspection and maintenance of fire doors to ensure proper operation.'
            ],
            [
                'service_id' => 'MS007',
                'name' => 'Smoke Detector Testing',
                'description' => 'Testing and replacement of smoke detectors.'
            ],
            [
                'service_id' => 'MS008',
                'name' => 'Carbon Monoxide Detector Inspection',
                'description' => 'Inspection and testing of carbon monoxide detectors.'
            ],
            [
                'service_id' => 'MS009',
                'name' => 'Fire Hydrant Flow Testing',
                'description' => 'Flow testing and maintenance of fire hydrants.'
            ],
            [
                'service_id' => 'MS010',
                'name' => 'Fire Pump Testing',
                'description' => 'Testing and servicing of fire pumps to ensure proper operation.'
            ],
            [
                'service_id' => 'MS011',
                'name' => 'Dry Riser Inspection',
                'description' => 'Inspection and testing of dry riser systems.'
            ],
            [
                'service_id' => 'MS012',
                'name' => 'Emergency Exit Sign Inspection',
                'description' => 'Inspection and maintenance of emergency exit signs.'
            ],
            [
                'service_id' => 'MS013',
                'name' => 'Fire Safety Training',
                'description' => 'Comprehensive fire safety training for staff members.'
            ],
            [
                'service_id' => 'MS014',
                'name' => 'Fire Risk Assessment',
                'description' => 'Conducting thorough fire risk assessments for various facilities.'
            ],
            [
                'service_id' => 'MS015',
                'name' => 'Fire Safety Plan Development',
                'description' => 'Development and review of fire safety plans.'
            ],
            [
                'service_id' => 'MS016',
                'name' => 'Portable Fire Equipment Check',
                'description' => 'Inspection of portable fire equipment such as fire blankets.'
            ],
            [
                'service_id' => 'MS017',
                'name' => 'Kitchen Fire Suppression Maintenance',
                'description' => 'Maintenance of kitchen-specific fire suppression systems.'
            ],
            [
                'service_id' => 'MS018',
                'name' => 'Foam System Inspection',
                'description' => 'Inspection and testing of foam-based fire suppression systems.'
            ],
            [
                'service_id' => 'MS019',
                'name' => 'Gas Detection System Servicing',
                'description' => 'Servicing and calibration of gas detection systems.'
            ],
            [
                'service_id' => 'MS020',
                'name' => 'Emergency Evacuation Drill',
                'description' => 'Planning and execution of emergency evacuation drills.'
            ],
            [
                'service_id' => 'MS021',
                'name' => 'Fire Extinguisher Recharging',
                'description' => 'Recharging and refilling of fire extinguishers.'
            ],
            [
                'service_id' => 'MS022',
                'name' => 'Fire-Resistant Coating Inspection',
                'description' => 'Application and inspection of fire-resistant coatings.'
            ],
            [
                'service_id' => 'MS023',
                'name' => 'Passive Fire Protection Check',
                'description' => 'Inspection of passive fire protection systems.'
            ],
            [
                'service_id' => 'MS024',
                'name' => 'Clean Agent System Maintenance',
                'description' => 'Maintenance of clean agent fire suppression systems.'
            ],
            [
                'service_id' => 'MS025',
                'name' => 'Electrical Fire Safety Inspection',
                'description' => 'Inspection of electrical systems for fire safety compliance.'
            ],
            [
                'service_id' => 'MS026',
                'name' => 'Wet Riser Inspection',
                'description' => 'Inspection and testing of wet riser systems.'
            ],
            [
                'service_id' => 'MS027',
                'name' => 'Fire Blanket Maintenance',
                'description' => 'Inspection and replacement of fire blankets.'
            ],
            [
                'service_id' => 'MS028',
                'name' => 'Specialized Fire Equipment Servicing',
                'description' => 'Servicing of specialized fire-fighting equipment.'
            ],
            [
                'service_id' => 'MS029',
                'name' => 'Fire Department Connection Check',
                'description' => 'Inspection and maintenance of fire department connections.'
            ],
            [
                'service_id' => 'MS030',
                'name' => 'Emergency Power System Check',
                'description' => 'Testing and maintenance of emergency power systems for fire safety equipment.'
            ],
        ];

        DB::table('mission_services')->insert($services);
    }
}
