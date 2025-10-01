<?php

namespace App\Http\Controllers\Api\WaveFire\Mission;

use App\Models\MissionFolder;
use Orion\Http\Controllers\RelationController;
use Orion\Concerns\DisableAuthorization;


class MissionOutOfServicesController extends RelationController
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionFolder::class; // or "App\Models\MissionFolder"

    protected $relation = 'out_of_service_equipments';

    public function searchableBy(): array
    {
        return ['equipment', 'the_reason'];
    }
}
