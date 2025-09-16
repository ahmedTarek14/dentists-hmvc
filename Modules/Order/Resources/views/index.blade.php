@extends('layouts.master')

@push('title', __('order::order.Orders'))

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('order::order.Orders List') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('order::order.Type') }}</th>
                            <th>{{ __('order::order.Requester') }}</th>
                            <th>{{ __('order::order.Provider') }}</th>
                            <th>{{ __('order::order.ServiceOrProduct') }}</th>
                            <th>{{ __('order::order.Status') }}</th>
                            <th>{{ __('order::order.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->service_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->provider_id == null ? 'primary' : 'info' }}">
                                        {{ $order->provider_id == null ? __('order::order.OfficialStore') : __('order::order.Service') }}
                                    </span>
                                </td>
                                <td>{{ $order->requester?->name }}</td>
                                <td>{{ $order->provider?->name ?? __('order::order.OfficialStore') }}</td>
                                <td>{{ $order->product?->name ?? $order->work?->title }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'delivered' ? 'success' : 'danger') }}">
                                        {{ __('order::order.' . ucfirst($order->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info">
                                        {{ __('order::order.Show') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">{{ __('order::order.NoOrders') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {!! $orders->links() !!}
            </div>
        </div>
    </div>
@endsection
