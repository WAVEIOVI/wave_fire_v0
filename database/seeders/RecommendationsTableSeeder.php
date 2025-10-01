<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecommendationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recommendations = [
            // Critical Recommendations
            ['name' => 'Immediately replace all expired fire extinguishers.'],
            ['name' => 'Repair malfunctioning fire alarm system components within 24 hours.'],
            ['name' => 'Clear all blocked fire exits and emergency routes immediately.'],
            ['name' => 'Fix any damaged fire doors that fail to close properly.'],
            ['name' => 'Address critical water supply issues affecting the sprinkler system.'],
            ['name' => 'Repair any compromised structural fire protection (e.g., damaged fire-resistant coatings).'],
            ['name' => 'Immediately remove and properly store any hazardous materials found in unauthorized areas.'],
            ['name' => 'Replace missing or damaged emergency lighting and exit signs.'],
            ['name' => 'Restore power to any non-functioning smoke detectors or fire alarm devices.'],
            ['name' => 'Immediately repair any damaged or leaking fire suppression system components.'],

            // Immediate Recommendations (To be addressed within 1 week)
            ['name' => 'Conduct an emergency staff training session on updated evacuation procedures.'],
            ['name' => 'Install additional fire extinguishers in areas with insufficient coverage.'],
            ['name' => 'Update and redistribute facility fire emergency action plans.'],
            ['name' => 'Implement a daily fire door inspection routine.'],
            ['name' => 'Establish a designated smoking area away from flammable materials and structures.'],
            ['name' => 'Install fire blankets in high-risk areas such as kitchens or laboratories.'],
            ['name' => 'Conduct a thorough inspection of all electrical systems and address any immediate hazards.'],
            ['name' => 'Implement a strict "hot work" permit system for any activities involving open flames or sparks.'],
            ['name' => 'Review and update the facility\'s fire risk assessment.'],
            ['name' => 'Arrange for the removal of excessive combustible materials from storage areas.'],

            // Short-Term Recommendations (To be addressed within 1-3 months)
            ['name' => 'Upgrade outdated fire alarm control panels.'],
            ['name' => 'Install additional smoke detectors in areas with insufficient coverage.'],
            ['name' => 'Implement a computerized maintenance management system for tracking fire safety equipment.'],
            ['name' => 'Conduct comprehensive fire safety training for all staff members.'],
            ['name' => 'Develop and implement a formal fire watch procedure for system outages or impairments.'],
            ['name' => 'Upgrade fire hydrants and water supply systems as needed.'],
            ['name' => 'Install or upgrade emergency communication systems throughout the facility.'],
            ['name' => 'Conduct a full review and update of fire safety policies and procedures.'],
            ['name' => 'Implement a regular schedule for cleaning and maintaining kitchen exhaust systems.'],
            ['name' => 'Upgrade fire-resistant coatings on structural elements where needed.'],
            ['name' => 'Install automatic fire suppression systems in server rooms or other critical areas.'],
            ['name' => 'Implement a formal inspection program for fire doors and dampers.'],
            ['name' => 'Develop a fire safety awareness program for facility occupants or visitors.'],
            ['name' => 'Upgrade emergency lighting systems to ensure adequate coverage and duration.'],
            ['name' => 'Implement a formal system for tracking and managing fire safety equipment inventory.'],

            // Long-Term Recommendations (To be addressed within 3-12 months)
            ['name' => 'Install a facility-wide sprinkler system if not already present.'],
            ['name' => 'Upgrade to an addressable fire alarm system for improved location accuracy.'],
            ['name' => 'Implement a smoke control system in large open areas or atriums.'],
            ['name' => 'Develop a comprehensive emergency response plan in coordination with local fire authorities.'],
            ['name' => 'Conduct regular joint training exercises with local fire department personnel.'],
            ['name' => 'Upgrade building management systems to better integrate fire safety controls.'],
            ['name' => 'Implement a mass notification system for large-scale emergencies.'],
            ['name' => 'Conduct a comprehensive fire flow test and upgrade water supply infrastructure if needed.'],
            ['name' => 'Develop a long-term capital improvement plan for ongoing fire safety enhancements.'],
            ['name' => 'Implement a formal fire safety management system compliant with international standards.'],
            ['name' => 'Upgrade to smart fire extinguishers with monitoring capabilities.'],
            ['name' => 'Install fire-resistant compartmentation in key areas to limit fire spread.'],
            ['name' => 'Implement a regular thermal imaging inspection program for electrical systems.'],
            ['name' => 'Develop a formal fire safety training and certification program for key personnel.'],
            ['name' => 'Conduct regular third-party audits of the facility\'s fire safety program.'],
            ['name' => 'Upgrade to IoT-enabled fire safety devices for real-time monitoring and predictive maintenance.'],
            ['name' => 'Implement a formal change management process for any modifications that may impact fire safety.'],
            ['name' => 'Develop a comprehensive business continuity and disaster recovery plan.'],
            ['name' => 'Establish a fire safety committee with representatives from all departments.'],
            ['name' => 'Implement a formal contractor management system to ensure adherence to fire safety protocols.'],
        ];

        DB::table('recommendations')->insert($recommendations);
    }
}
