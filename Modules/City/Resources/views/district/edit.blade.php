<form class="modal-content ajax-form"
    action="{{ route('admin.district.update', ['city' => $city->id, 'district' => $district->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">
            {{ __('city::district.Edit District') }}
        </h5>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('city::district.District Name') }}</label>
            <input type="text" class="form-control" name="name" value="{{ $district->name }}" required>
        </div>

        <div class="mb-3">
            <label for="shipping_fees" class="form-label">{{ __('city::district.Shipping Fees') }}</label>
            <input type="number" step="0.01" min="0" class="form-control" name="shipping_fees"
                value="{{ $district->shipping_fees }}" required>
        </div>
    </div>
    <div class="modal-footer text-end">
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">
            {{ __('city::district.Cancel') }}
        </button>
        <button type="submit" class="btn btn-primary" data-save-text="{{ __('city::district.Save') }}">
            {{ __('city::district.Save') }}
        </button>
    </div>
</form>
