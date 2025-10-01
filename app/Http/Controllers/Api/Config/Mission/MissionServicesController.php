<?php

namespace App\Http\Controllers\Api\Config\Mission;

use App\Models\MissionService;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class MissionServicesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = MissionService::class; // or "App\Models\MissionService"

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
