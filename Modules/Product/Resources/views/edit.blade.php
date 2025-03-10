<form class="modal-content ajax-form" action="{{ route('admin.product.update', ['product' => $product->id]) }}"
    method="PUT">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">
            {{ __('product::product.Edit Product') }}
        </h5>
    </div>

    <div class="modal-body">
        <label for="name" class="form-label">{{ __('product::product.Product Name') }}</label>
        <input type="text" class="form-control" name="name" value="{{ $product->name }}">

        <label for="description" class="form-label mt-2">{{ __('product::product.Description') }}</label>
        <textarea class="form-control" name="description">{{ $product->description }}</textarea>

        <label for="price" class="form-label mt-2">{{ __('product::product.Price') }}</label>
        <input type="number" class="form-control" name="price" step="0.01" value="{{ $product->price }}">

        <label class="form-label mt-2">{{ __('product::product.Image') }}</label>
        <input type="file" class="form-control" name="image" id="product-image-input">

        <div class="text-center mt-3">
            <img src="{{ $product->image_path }}" id="product-image-preview" class="img-fluid rounded"
                style="max-width: 150px;">
        </div>

        <label for="quantity" class="form-label mt-2">{{ __('product::product.Quantity') }}</label>
        <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}">

    </div>

    <div class="modal-footer text-end">
        <button type="button" data-bs-dismiss="modal"
            class="btn btn-secondary">{{ __('product::product.Cancel') }}</button>
        <button type="submit" class="btn btn-primary"
            data-save-text="{{ __('product::product.Save') }}">{{ __('product::product.Save') }}</button>
    </div>
</form>


<script>
    document.getElementById('product-image-input').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            document.getElementById('product-image-preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
