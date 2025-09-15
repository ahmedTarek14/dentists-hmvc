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
                return api_response_error('Please provide a search query');
            }

            // Get Doctors only
            $doctors = User::where('type', 'doctor')
                ->where('name', 'like', "%$keyword%")
                ->get();

            // Get Works
            $works = Work::where('title', 'like', "%$keyword%")
                ->with('technician')
                ->get();

            // Get Products
            $products = Product::where('name', 'like', "%$keyword%")
                ->get();

            // Merge all results into one collection
            $allResults = collect()
                ->merge($doctors)
                ->merge($works)
                ->merge($products);

            // Transform results
            $results = SearchResource::collection($allResults)->response()->getData(true);

            return api_response_success($results);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
