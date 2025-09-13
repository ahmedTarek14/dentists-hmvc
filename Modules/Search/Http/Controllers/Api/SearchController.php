<?php

namespace Modules\Search\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;
use Modules\Search\Transformers\SearchResource;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $keyword = $request->get('q');

            if (!$keyword) {
                return response()->json(['message' => 'Please provide a search query'], 400);
            }

            $doctors = User::where('type', 'doctor')
                ->where('name', 'like', "%$keyword%")
                ->get();

            $technicians = User::where('type', 'technician')
                ->where('name', 'like', "%$keyword%")
                ->with('works')
                ->get();

            $works = Work::where('title', 'like', "%$keyword%")
                ->get();


            $products = Product::where('name', 'like', "%$keyword%")
                ->get();

            $results = [
                'doctors'     => SearchResource::collection($doctors)->response()->getData(true),
                'technicians' => SearchResource::collection($technicians)->response()->getData(true),
                'works'       => SearchResource::collection($works)->response()->getData(true),
                'products'    => SearchResource::collection($products)->response()->getData(true),
            ];

            return api_response_success($results);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
