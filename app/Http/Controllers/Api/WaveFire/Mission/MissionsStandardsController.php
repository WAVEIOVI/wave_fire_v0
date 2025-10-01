<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class MissionsStandardsController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'standards';

    public function searchableBy(): array
    {
        return ['standard_id', 'name'];
    }
    public function filterableBy(): array
    {
        return ['standard_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
