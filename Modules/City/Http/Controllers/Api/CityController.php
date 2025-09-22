<?php

namespace Modules\City\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Transformers\CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function cities()
    {
        try {
            $cities = City::where('status', '1')
                ->whereHas('districts') // بس المدن اللي عندها ديستريكت
                ->orderBy('id', 'desc')
                ->get();
            $data = CityResource::collection($cities)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
