<form class="modal-content ajax-form" action="{{ route('admin.types.update', ['type' => $type->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">{{ __('user::user.Edit Type') }}</h5>
    </div>

    <div class="modal-body">
        <label class="form-label">{{ __('user::user.Name') }}</label>
        <input type="text" class="form-control" name="name" value="{{ $type->name }}">
    </div>

    <div class="modal-footer text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('user::user.Cancel') }}
        </button>
        <button type="submit" class="btn btn-primary" data-save-text="{{ __('user::user.Save') }}">
            {{ __('user::user.Save') }}
        </button>
    </div>
</form>
