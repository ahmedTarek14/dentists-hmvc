<?php

namespace Modules\City\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\District;
use Modules\City\Transformers\DistrictResource;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        try {
            $districts = District::where('city_id', $id)
                ->where('status', '1')
                ->whereHas('city', function ($q) {
                    $q->where('status', '1');
                })
                ->orderBy('id', 'desc')
                ->get();
            $data = DistrictResource::collection($districts)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
