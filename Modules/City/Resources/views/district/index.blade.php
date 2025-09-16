@extends('layouts.master')

@push('breadcrumb')
    <li class="breadcrumb-item text-sm"><a href="{{ route('admin.city.index') }}">{{ __('city::city.Cities') }}</a></li>
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
        {{ $city->name }} - {{ __('city::district.Districts') }}
    </li>
@endpush

@push('title')
    {{ __('city::district.All Districts for :city', ['city' => $city->name]) }}
@endpush

@push('models')
    <div class="modal fade" id="add-district-modal">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.district.store', ['city' => $city->id]) }}"
                method="post">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="fw-medium fs-base me-auto">{{ __('city::district.Add New District') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('city::district.District Name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('city::district.Shipping Fees') }}</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="shipping_fees"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('city::district.Cancel') }}</button>
                    <button type="submit" class="btn btn-primary"
                        data-save-text="{{ __('city::district.Save') }}">{{ __('city::district.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h6>{{ __('city::district.Districts Table') }}</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-district-modal">
                {{ __('city::district.Add District') }}
            </button>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('city::district.District Name') }}</th>
                        <th>{{ __('city::district.Shipping Fees') }}</th>
                        <th class="text-center">{{ __('city::district.Status') }}</th>
                        <th class="text-center">{{ __('city::district.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($districts as $district)
                        <tr>
                            <td>{{ $district->name }}</td>
                            <td>{{ number_format($district->shipping_fees, 2) }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $district->status ? 'success' : 'danger' }}">
                                    {{ $district->status ? __('city::district.Active') : __('city::district.Inactive') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning toggle-status" data-id="{{ $district->id }}">
                                    {{ $district->status ? __('city::city.Deactivate') : __('city::city.Activate') }}
                                </button>


                                <a href="javascript:;" class="btn btn-sm btn-info btn-modal-view"
                                    data-url="{{ route('admin.district.edit', ['city' => $city->id, 'district' => $district->id]) }}">
                                    {{ __('city::district.Edit District') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">{{ __('No districts available') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $districts->links() !!}
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.querySelectorAll('.toggle-status').forEach(button => {
            button.addEventListener('click', function() {
                let districtId = this.getAttribute('data-id');
                let confirmAction = confirm(
                    "{{ __('city::city.Are you sure you want to change the status?') }}"
                );
                if (confirmAction) {
                    fetch(`{{ url('admin/district/toggle-status') }}/${districtId}`, {
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
