<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddonResource;
use App\Services\AtlassianService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AtlassianController extends Controller
{
    public function index(Request $request, AtlassianService $service)
    {
        $params = $this->validate($request, [
            'application' => 'string',
            'limit'       => 'integer',
            'offset'      => 'integer',
            'category'    => 'string',
            'filter'      => 'string',
            'hosting'     => ['string', Rule::in(['any', 'cloud', 'server', 'datacenter'])],
            'text'        => 'string',
            'cost'        => ['string', Rule::in(['free', 'marketplace', 'orderable', 'paid'])],
        ]);

        $response = $service->getAddonsList($params);

        return AddonResource::collection($response->_embedded->addons);
    }
}
