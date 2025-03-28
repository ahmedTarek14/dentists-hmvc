<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Transformers\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $products = Product::withAvg('ratings', 'rating')
                ->orderByDesc('ratings_avg_rating')
                ->orderByDesc('id')
                ->paginate(10);
            $data = ProductResource::collection($products)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
