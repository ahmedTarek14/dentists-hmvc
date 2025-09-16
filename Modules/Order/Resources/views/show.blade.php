@extends('layouts.master')

@push('title', __('order::order.OrderDetails'))

@section('content')
    <div class="card shadow-sm animate__animated animate__fadeIn">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('order::order.OrderDetails') }} #{{ $order->service_number ?? '-' }}</h5>

            {{-- Change Status --}}
            <div class="dropdown">
                @php
                    $statusClass =
                        $order->status == 'pending'
                            ? 'btn-warning'
                            : ($order->status == 'delivered'
                                ? 'btn-success'
                                : 'btn-danger');
                @endphp

                <button class="btn btn-sm {{ $statusClass }} dropdown-toggle" type="button" id="statusDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-arrow-repeat me-1"></i>
                    {{ __('order::order.' . ucfirst($order->status)) }}
                </button>

                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                    <li>
                        <form method="POST" action="{{ route('admin.orders.update.status', $order) }}">
                            @csrf
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-hourglass-split text-warning me-2"></i>
                                {{ __('order::order.Pending') }}
                            </button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.orders.update.status', $order) }}">
                            @csrf
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                {{ __('order::order.Delivered') }}
                            </button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.orders.update.status', $order) }}">
                            @csrf
                            <input type="hidden" name="status" value="canceled">
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                {{ __('order::order.Canceled') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-body">

            {{-- General Info --}}
            <div class="mb-4 border-bottom pb-3">
                <h6 class="text-muted">{{ __('order::order.GeneralInfo') }}</h6>
                <p><strong>{{ __('order::order.OrderID') }}:</strong> {{ $order->service_number ?? '-' }}</p>
                <p><strong>{{ __('order::order.Type') }}:</strong>
                    {{ $order->product_id ? __('order::order.OfficialStore') : __('order::order.Service') }}
                </p>
                <p><strong>{{ __('order::order.Status') }}:</strong>
                    <span
                        class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'delivered' ? 'success' : 'danger') }}">
                        {{ __('order::order.' . ucfirst($order->status)) }}
                    </span>
                </p>
                <p><strong>{{ __('order::order.CreatedAt') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>{{ __('order::order.UpdatedAt') }}:</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</p>
            </div>

            {{-- Requester --}}
            <div class="mb-4 border-bottom pb-3">
                <h6 class="text-muted">{{ __('order::order.RequesterInfo') }}</h6>
                <p><strong>{{ __('order::order.Name') }}:</strong> {{ $order->requester?->name ?? '-' }}</p>
                <p><strong>{{ __('order::order.Email') }}:</strong> {{ $order->requester?->email ?? '-' }}</p>
            </div>

            {{-- Provider --}}
            <div class="mb-4 border-bottom pb-3">
                <h6 class="text-muted">{{ __('order::order.ProviderInfo') }}</h6>
                <p><strong>{{ __('order::order.Name') }}:</strong>
                    {{ $order->provider?->name ?? __('order::order.OfficialStore') }}</p>
                <p><strong>{{ __('order::order.Email') }}:</strong>
                    {{ $order->provider?->email ?? __('order::order.OfficialStore') }}</p>
            </div>

            {{-- Shipping Route --}}
            <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h6 class="text-primary mb-3">{{ __('order::order.ShippingRoute') }}</h6>
                    <div class="d-flex align-items-center justify-content-between flex-wrap">

                        {{-- From --}}
                        <div class="p-3 border rounded bg-light flex-fill me-2 text-center hover-card">
                            <h6 class="text-muted">{{ __('order::order.From') }}</h6>
                            <p class="fw-bold mb-1">{{ $order->city_from?->name ?? '-' }}</p>
                            <small class="text-muted">{{ $order->district_from?->name ?? '-' }}</small>
                        </div>

                        {{-- Arrow --}}
                        <div class="mx-2 text-center">
                            @if (app()->getLocale() === 'ar')
                                <i class="bi bi-arrow-left-circle-fill fs-3 text-primary animated-arrow"></i>
                            @else
                                <i class="bi bi-arrow-right-circle-fill fs-3 text-primary animated-arrow"></i>
                            @endif
                        </div>

                        {{-- To --}}
                        <div class="p-3 border rounded bg-light flex-fill ms-2 text-center hover-card">
                            <h6 class="text-muted">{{ __('order::order.To') }}</h6>
                            <p class="fw-bold mb-1">{{ $order->city_to?->name ?? '-' }}</p>
                            <small class="text-muted">{{ $order->district_to?->name ?? '-' }}</small>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Order Details --}}
            <div class="border rounded p-3 mb-3 hover-card">
                <h6 class="text-primary">{{ __('order::order.Details') }}</h6>
                <p><strong>{{ __('order::order.ServiceOrProduct') }}:</strong>
                    {{ $order->product?->name ?? ($order->work?->title ?? '-') }}
                </p>
                <p><strong>{{ __('order::order.ProductPrice') }}:</strong> {{ $order->product_price }}</p>
                <p><strong>{{ __('order::order.ShippingFees') }}:</strong> {{ $order->shipping_fees }}</p>
                <p><strong>{{ __('order::order.TotalPrice') }}:</strong> {{ $order->total_price }}</p>
            </div>
        </div>
    </div>
@endsection

@push('css')
    {{-- Bootstrap Icons & Animate.css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .animated-arrow {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0.7;
            }
        }
    </style>
@endpush
