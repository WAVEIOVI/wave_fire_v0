<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class MissionsSuggestionsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'suggestions';
    protected $pivotFillable = [
        'suggestion_status'
    ];

    public function searchableBy(): array
    {
        return ['name'];
    }
    public function filterableBy(): array
    {
        return ['name', 'pivot.suggestion_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
