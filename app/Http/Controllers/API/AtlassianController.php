<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddonResource;
use App\Services\AtlassianService;
use Illuminate\Http\Request;

class AtlassianController extends Controller
{
    public function index(Request $request, AtlassianService $service)
    {
        $data = $service->getAddonsList(
            $request->all()
        );

        return AddonResource::collection($data->_embedded->addons);
    }
}
