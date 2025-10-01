<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class MissionHazardsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'risk_assessments';

    public function searchableBy(): array
    {
        return ['hazard', 'description', 'mitigation_strategy', 'likelihood', 'severity', 'risk_level'];
    }
}
