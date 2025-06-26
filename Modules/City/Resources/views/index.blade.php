@extends('layouts.master')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ __('city::city.Cities') }}</li>
@endpush
@push('title')
    {{ __('city::city.All Cities') }}
@endpush
@push('models')
    <div class="modal fade" id="add-city-modal">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.city.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="fw-medium fs-base me-auto">{{ __('city::city.Add New City') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('city::city.City Name') }}</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('city::city.Shipping Fees') }}</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="shipping_fees">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('city::city.Cancel') }}</button>
                    <button type="submit" class="btn btn-primary"
                        data-save-text="{{ __('city::city.Save') }}">{{ __('city::city.Save') }}</button>
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
                    <h6>{{ __('city::city.Cities Table') }}</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#add-city-modal">{{ __('city::city.Add City') }}</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('city::city.City Name') }}</th>
                                    <th>{{ __('city::city.Shipping Fees') }}</th>
                                    <th class="text-center">{{ __('city::city.Status') }}</th>
                                    <th class="text-center">{{ __('city::city.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cities as $city)
                                    <tr>
                                        <td>{{ $city->name }}</td>
                                        <td>{{ number_format($city->shipping_fees, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $city->status ? 'success' : 'danger' }}">
                                                {{ $city->status ? __('city::city.Active') : __('city::city.Inactive') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning toggle-status"
                                                data-id="{{ $city->id }}">
                                                {{ $city->status ? __('city::city.Deactivate') : __('city::city.Activate') }}
                                            </button>

                                            <a href="javascript:;" class="btn btn-sm btn-info btn-modal-view"
                                                data-url="{{ route('admin.city.edit', ['city' => $city->id]) }}">
                                                {{ __('city::city.Edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">{{ __('No cities available') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $cities->links() !!}
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
                let cityId = this.getAttribute('data-id');
                let confirmAction = confirm(
                    "{{ __('city::city.Are you sure you want to change the status?') }}");
                if (confirmAction) {
                    fetch(`{{ url('admin/city/toggle-status') }}/${cityId}`, {
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
