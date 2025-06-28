@extends('layouts.master')
@php
    $type = $type ?? request()->route('type');
@endphp

@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
        {{ $type === 'doctor' ? __('user::user.Doctors') : __('user::user.Technicians') }}
    </li>
@endpush

@push('title')
    {{ __('user::user.All ' . ucfirst($type) . 's') }}
@endpush

@push('models')
    <div class="modal fade" id="add-user-modal">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.user.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="fw-medium fs-base me-auto">{{ __('user::user.Add New ' . ucfirst($type)) }}</h5>
                </div>
                <div class="modal-body">
                    <label class="form-label">{{ __('user::user.Name') }}</label>
                    <input type="text" class="form-control" name="name">

                    <label class="form-label mt-2">{{ __('user::user.Email') }}</label>
                    <input type="email" class="form-control" name="email">

                    <label class="form-label mt-2">{{ __('user::user.Password') }}</label>
                    <input type="password" class="form-control" name="password">

                    <input type="hidden" name="type" value="{{ $type }}">
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
                    <h6>{{ __('user::user.' . ucfirst($type) . 's Table') }}</h6>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-user-modal">
                            {{ __('user::user.Add New ' . ucfirst($type)) }}
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('user::user.Name') }}</th>
                                    <th>{{ __('user::user.Email') }}</th>
                                    <th class="text-center">{{ __('user::user.Status') }}</th>
                                    @if ($type === 'doctor')
                                        <th class="text-center">{{ __('user::user.Total Orders') }}</th>
                                    @elseif ($type === 'technician')
                                        <th class="text-center">{{ __('user::user.Avg Rating') }}</th>
                                        <th class="text-center">{{ __('user::user.Orders Received') }}</th>
                                    @endif
                                    <th class="text-center">{{ __('user::user.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                                                {{ $user->status ? __('user::user.Active') : __('user::user.Inactive') }}
                                            </span>
                                        </td>
                                        @if ($type === 'doctor')
                                            <td class="text-center">
                                                {{ $user->doctorOrders->count() }}
                                            </td>
                                        @elseif ($type === 'technician')
                                            <td class="text-center">
                                                {{ number_format($user->averageRating() ?? 0, 2) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $user->providerOrders->count() }}
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning toggle-status"
                                                data-id="{{ $user->id }}">
                                                {{ $user->status ? __('user::user.Deactivate') : __('user::user.Activate') }}
                                            </button>
                                            <a href="javascript:;" class="btn btn-sm btn-info btn-modal-view"
                                                data-url="{{ route('admin.user.edit', $user->id) }}">{{ __('user::user.Edit') }}</a>
                                            @if ($type === 'technician')
                                                <a href="#" class="btn btn-sm btn-secondary">
                                                    {{ __('user::user.View Works') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $type === 'technician' ? 6 : ($type === 'doctor' ? 5 : 4) }}"
                                            class="text-center text-muted">
                                            {{ __('user::user.No users found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 px-3">
                            {!! $users->links() !!}
                        </div>
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
                    fetch(`{{ url('admin/user/toggle-status') }}/${userId}`, {
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
