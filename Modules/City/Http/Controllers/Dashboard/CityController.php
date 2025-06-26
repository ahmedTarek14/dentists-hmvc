<?php

namespace Modules\City\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\Dashboard\CityRequest;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::latest()->paginate(15);
        return view('city::index', compact('cities'));
    }

    public function store(CityRequest $request)
    {
        try {
            City::create($request->validated());

            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function edit(City $city)
    {
        return view('city::edit', compact('city'));
    }

    public function update(CityRequest $request, City $city)
    {
        try {
            $city->update($request->validated());

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function toggleStatus(City $city)
    {
        if ($city->status == '1') {
            $city->status = '0';
        } else {
            $city->status = '1';
        }
        $city->save();

        return response()->json(['message' => __('City status updated successfully.')]);
    }
}
