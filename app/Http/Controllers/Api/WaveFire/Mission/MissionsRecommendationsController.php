<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class MissionsRecommendationsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'recommendations';
    protected $pivotFillable = [
        'recommendation_status'
    ];

    public function searchableBy(): array
    {
        return ['name'];
    }
    public function filterableBy(): array
    {
        return ['name', 'pivot.recommendation_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
