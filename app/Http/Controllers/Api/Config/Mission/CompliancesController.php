<?php

namespace App\Http\Controllers\Api\Config\Mission;

use App\Models\Compliance;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class CompliancesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Compliance::class; // or "App\Models\Compliance"

    public function searchableBy(): array
    {
        return ['compliance_desc', 'compliance_status', 'applicable_standard'];
    }
    public function filterableBy(): array
    {
        return ['compliance_desc', 'compliance_status'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
}
