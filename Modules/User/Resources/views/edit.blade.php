<form class="modal-content ajax-form" action="{{ route('admin.user.update', ['user' => $user->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">
            {{ __('user::user.Edit ' . ucfirst($user->type)) }}
        </h5>
    </div>

    <div class="modal-body">
        <label class="form-label">{{ __('user::user.Name') }}</label>
        <input type="text" class="form-control" name="name" value="{{ $user->name }}">

        <label class="form-label mt-2">{{ __('user::user.Email') }}</label>
        <input type="email" class="form-control" name="email" value="{{ $user->email }}">

        {{-- Optional: Password update --}}
        <label class="form-label mt-2">{{ __('user::user.Password') }}
            ({{ __('user::user.Leave empty if not changing') }})</label>
        <input type="password" class="form-control" name="password">
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
