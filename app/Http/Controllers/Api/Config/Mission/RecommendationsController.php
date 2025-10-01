<?php

namespace App\Http\Controllers\Api\Config\Mission;

use App\Models\Recommendation;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class RecommendationsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Recommendation::class; // or "App\Models\Recommendation"

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
