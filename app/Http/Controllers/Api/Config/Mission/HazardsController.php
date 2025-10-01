<?php

namespace App\Http\Controllers\Api\Config\Mission;

use App\Models\Hazard;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class HazardsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Hazard::class; // or "App\Models\Hazard"

    public function searchableBy(): array
    {
        return ['name'];
    }
    public function filterableBy(): array
    {
        return ['name'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
