<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class MissionsCompliancesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'compliances';
    protected $pivotFillable = [
        'action'
    ];

    public function searchableBy(): array
    {
        return ['compliance_desc'];
    }
    public function filterableBy(): array
    {
        return ['compliance_desc', 'compliance_status', 'pivot.action'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
