<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\Auth\Transformers\UserResource;
use Modules\User\Transformers\DoctorResource;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $doctors = User::where('type', 'doctor')
                ->where('status', '1')
                ->orderBy('id', 'asc') // use 'desc' if you want latest first
                ->paginate(10);


            $data = DoctorResource::collection($doctors)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
