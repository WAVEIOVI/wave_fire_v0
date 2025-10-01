<?php

namespace App\Http\Controllers\Api\Config\Mission;

use App\Models\Suggestion;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class SuggestionsController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Suggestion::class; // or "App\Models\Suggestion"

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
