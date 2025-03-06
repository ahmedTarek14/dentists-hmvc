<?php

namespace Modules\Product\Http\Controllers\Dashboard;

use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\Dashboard\ProductRequest;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('product::index', compact('products'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
            $data['image'] = $request->hasFile('image') ? $this->image_manipulate($request->image, 'products') : null;
            Product::create($data);
            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function edit(Product $product)
    {
        return view('product::edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $this->image_delete($product->image, 'products');
                $data['image'] = $this->image_manipulate($request->image, 'products');
            }

            $product->update($data);
            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->image_delete($product->image, 'products');
            $product->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return error_response();
        }
    }
}