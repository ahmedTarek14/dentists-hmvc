@extends('layouts.master')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ __('product::product.Products') }}</li>
@endpush
@push('title')
    {{ __('product::product.All Products') }}
@endpush
@push('models')
    <div class="modal fade" id="add-product-modal">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.product.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="fw-medium fs-base me-auto">{{ __('product::product.Add New Product') }}</h5>
                </div>
                <div class="modal-body">
                    <label class="form-label">{{ __('product::product.Product Name') }}</label>
                    <input type="text" class="form-control" name="name">

                    <label class="form-label">{{ __('product::product.Description') }}</label>
                    <textarea class="form-control" name="description"></textarea>

                    <label class="form-label">{{ __('product::product.Price') }}</label>
                    <input type="number" class="form-control" name="price" step="0.01">

                    <label class="form-label">{{ __('product::product.Image') }}</label>
                    <input type="file" class="form-control" name="image" onchange="previewImage(event)">

                    <div class="text-center my-3">
                        <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded"
                            style="display: none; max-width: 150px;">
                    </div>

                    <label class="form-label">{{ __('product::product.Quantity') }}</label>
                    <input type="number" class="form-control" name="quantity">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('product::product.Cancel') }}</button>
                    <button type="submit" class="btn btn-primary"
                        data-save-text="{{ __('product::product.Save') }}">{{ __('product::product.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('product::product.Products Table') }}</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#add-product-modal">{{ __('product::product.Add Product') }}</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('product::product.Product Name') }}</th>
                                    <th>{{ __('product::product.Description') }}</th>
                                    <th>{{ __('product::product.Price') }}</th>
                                    <th>{{ __('product::product.Image') }}</th>
                                    <th class="text-center">{{ __('product::product.Quantity') }}</th>
                                    <th class="text-center">{{ __('product::product.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description ?? __('product::product.No Description') }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td><img src="{{ $product->image_path }}" width="75" height="75"></td>
                                        <td class="text-center">{{ $product->quantity }}</td>
                                        <td class="text-center">
                                            <a href="javascript:;" class="btn btn-sm btn-info btn-modal-view"
                                                data-url="{{ route('admin.product.edit', ['product' => $product->id]) }}">{{ __('product::product.Edit') }}</a>
                                            <a href="javascript:;" class="btn btn-sm btn-danger delete-btn"
                                                data-url="{{ route('admin.product.destroy', ['product' => $product->id]) }}">
                                                {{ __('product::product.Delete') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">{{ __('No products available') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $products->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function previewImage(event) {
            let input = event.target;
            let reader = new FileReader();

            reader.onload = function() {
                let img = document.getElementById('image-preview');
                img.src = reader.result;
                img.style.display = 'block';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
