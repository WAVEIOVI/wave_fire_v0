<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;


class MissionsServicesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'mission_services';

    public function searchableBy(): array
    {
        return ['service_id', 'name', 'description'];
    }
    public function filterableBy(): array
    {
        return ['service_id'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
