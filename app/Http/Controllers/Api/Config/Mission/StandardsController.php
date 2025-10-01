<?php

namespace App\Http\Controllers\Api\Config\Mission;

use App\Models\Standard;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class StandardsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Standard::class; // or "App\Models\Standard"

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
