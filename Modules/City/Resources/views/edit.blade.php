<form class="modal-content ajax-form" action="{{ route('admin.city.update', ['city' => $city->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">
            {{ __('city::city.Edit City') }}
        </h5>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('city::city.City Name') }}</label>
            <input type="text" class="form-control" name="name" value="{{ $city->name }}">
        </div>
    </div>
    <div class="modal-footer text-end">
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">{{ __('city::city.Cancel') }}</button>
        <button type="submit" class="btn btn-primary"
            data-save-text="{{ __('city::city.Save') }}">{{ __('city::city.Save') }}</button>
    </div>
</form>
