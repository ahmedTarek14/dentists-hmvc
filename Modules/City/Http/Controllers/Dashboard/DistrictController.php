<?php

namespace Modules\City\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Entities\District;
use Modules\City\Http\Requests\Dashboard\DistrictRequest;

class DistrictController extends Controller
{
    public function index(City $city)
    {
        $districts = $city->districts()->latest()->paginate(15);
        return view('city::district.index', compact('districts', 'city'));
    }

    public function store(DistrictRequest $request, City $city)
    {
        $city->districts()->create($request->validated());
        return add_response();
    }

    public function edit(City $city, District $district)
    {
        return view('city::district.edit', compact('district', 'city'));
    }

    public function update(DistrictRequest $request, City $city, District $district)
    {
        $district->update($request->validated());
        return update_response();
    }

    public function toggleStatus(District $district)
    {
        if ($district->status == '1') {
            $district->status = '0';
        } else {
            $district->status = '1';
        }
        $district->save();

        return response()->json(['message' => __('District status updated successfully.')]);
    }
}
