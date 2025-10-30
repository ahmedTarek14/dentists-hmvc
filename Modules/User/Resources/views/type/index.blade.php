@extends('layouts.master')

@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
        {{ __('user::user.Types') }}
    </li>
@endpush

@push('title')
    {{ __('user::user.Types') }}
@endpush

@push('models')
    <div class="modal fade" id="add-type-modal">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.types.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="fw-medium fs-base me-auto">{{ __('user::user.Add New Type') }}</h5>
                </div>
                <div class="modal-body">
                    <label class="form-label">{{ __('user::user.Name') }}</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('user::user.Cancel') }}</button>
                    <button type="submit" class="btn btn-primary"
                        data-save-text="{{ __('user::user.Save') }}">{{ __('user::user.Save') }}</button>
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
                    <h6>{{ __('user::user.Types Table') }}</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-type-modal">
                        {{ __('user::user.Add New Type') }}
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('user::user.Name') }}</th>
                                    <th>{{ __('user::user.Status') }}</th>
                                    <th class="text-center">{{ __('user::user.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($types as $type)
                                    <tr>
                                        <td>{{ $type->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $type->status ? 'success' : 'danger' }}">
                                                {{ $type->status ? __('user::user.Active') : __('user::user.Inactive') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning toggle-status"
                                                data-id="{{ $type->id }}">
                                                {{ $type->status ? __('user::user.Deactivate') : __('user::user.Activate') }}
                                            </button>


                                            <a href="javascript:;" class="btn btn-sm btn-info btn-modal-view"
                                                data-url="{{ route('admin.types.edit', $type->id) }}">{{ __('user::user.Edit') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('user::user.No types found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <div class="mt-3 px-3">
                                {!! $types->links() !!}
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.querySelectorAll('.toggle-status').forEach(button => {
            button.addEventListener('click', function() {
                let userId = this.getAttribute('data-id');
                let confirmAction = confirm(
                    "{{ __('city::city.Are you sure you want to change the status?') }}");
                if (confirmAction) {
                    fetch(`{{ url('admin/types/toggle-status') }}/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    }).then(response => response.json()).then(data => {
                        location.reload();
                    });
                }
            });
        });
    </script>
@endpush
