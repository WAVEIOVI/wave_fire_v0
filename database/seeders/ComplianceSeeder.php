<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compliances = [
            [
                'compliance_desc' => 'Portable fire extinguishers work as intended to provide a first line of defense against fires of limited size.',
                'applicable_standard' => 'NFPA 10 - 2018',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Design and installation of automatic fire sprinkler systems meet minimum requirements.',
                'applicable_standard' => 'NFPA 13 - 2019',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Periodic inspection, testing, and maintenance of water-based fire protection systems are up to standard.',
                'applicable_standard' => 'NFPA 25 - 2020',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Installation, performance, testing, and maintenance of fire alarm systems are compliant.',
                'applicable_standard' => 'NFPA 72 - 2019',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Design, installation, testing, and maintenance of clean agent fire extinguishing systems meet requirements.',
                'applicable_standard' => 'NFPA 2001 - 2018',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Design, installation, and maintenance of gaseous fire-extinguishing systems follow guidelines.',
                'applicable_standard' => 'ISO 14520 - 2015',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Construction, performance, and testing of portable fire extinguishers are compliant.',
                'applicable_standard' => 'EN 3 - 2007',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Installation and maintenance of fire extinguishing equipment meet recommendations.',
                'applicable_standard' => 'BS 5306 - 2018',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Fire testing requirements for fire extinguishing systems designed for commercial cooking equipment are met.',
                'applicable_standard' => 'UL 300 - 2018',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Design, installation, and maintenance of foam fire-extinguishing systems meet requirements.',
                'applicable_standard' => 'NFPA 11 - 2021',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Installation and maintenance of fire detection and alarm systems are up to standard.',
                'applicable_standard' => 'APSAD R4 - 2017',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Design, installation, and maintenance of sprinkler systems meet French standards.',
                'applicable_standard' => 'APSAD R5 - 2018',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Fire safety requirements in Tunisia are met according to the National Office for Civil Protection.',
                'applicable_standard' => 'NOCPT 123 - 2020',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Portable fire extinguishers failed to work as intended in some instances.',
                'applicable_standard' => 'NFPA 10 - 2018',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Design and installation of automatic fire sprinkler systems do not meet minimum requirements in some areas.',
                'applicable_standard' => 'NFPA 13 - 2019',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Periodic inspection, testing, and maintenance of water-based fire protection systems were not performed as required.',
                'applicable_standard' => 'NFPA 25 - 2020',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some fire alarm systems do not meet the installation, performance, testing, and maintenance standards.',
                'applicable_standard' => 'NFPA 72 - 2019',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some clean agent fire extinguishing systems do not meet design, installation, testing, and maintenance requirements.',
                'applicable_standard' => 'NFPA 2001 - 2018',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some gaseous fire-extinguishing systems do not follow design, installation, and maintenance guidelines.',
                'applicable_standard' => 'ISO 14520 - 2015',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some portable fire extinguishers do not meet construction, performance, and testing standards.',
                'applicable_standard' => 'EN 3 - 2007',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some fire extinguishing equipment installations and maintenance do not meet recommendations.',
                'applicable_standard' => 'BS 5306 - 2018',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some fire extinguishing systems designed for commercial cooking equipment do not meet fire testing requirements.',
                'applicable_standard' => 'UL 300 - 2018',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some foam fire-extinguishing systems do not meet design, installation, and maintenance requirements.',
                'applicable_standard' => 'NFPA 11 - 2021',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some fire detection and alarm systems do not meet French installation and maintenance standards.',
                'applicable_standard' => 'APSAD R4 - 2017',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some sprinkler systems do not meet French design, installation, and maintenance standards.',
                'applicable_standard' => 'APSAD R5 - 2018',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Some fire safety requirements in Tunisia are not met according to the National Office for Civil Protection.',
                'applicable_standard' => 'NOCPT 123 - 2020',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Most portable fire extinguishers work as intended, except for a few isolated cases.',
                'applicable_standard' => 'NFPA 10 - 2018',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'Overall, the design and installation of automatic fire sprinkler systems meet minimum requirements, with minor exceptions.',
                'applicable_standard' => 'NFPA 13 - 2019',
                'compliance_status' => 'compliant'
            ],
            [
                'compliance_desc' => 'There are some gaps in periodic inspection, testing, and maintenance of water-based fire protection systems.',
                'applicable_standard' => 'NFPA 25 - 2020',
                'compliance_status' => 'non-compliant'
            ],
            [
                'compliance_desc' => 'Most fire alarm systems meet the installation, performance, testing, and maintenance standards, with a few non-compliant instances.',
                'applicable_standard' => 'NFPA 72 - 2019',
                'compliance_status' => 'compliant'
            ],
        ];

        DB::table('compliances')->insert($compliances);
    }
}
