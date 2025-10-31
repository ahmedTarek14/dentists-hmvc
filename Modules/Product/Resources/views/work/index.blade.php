@extends('layouts.master')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ __('product::product.Works') }}</li>
@endpush
@push('title')
    {{ __('product::product.All Works') }}
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('product::product.Works Table') }}</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('product::product.Work Name') }}</th>
                                    <th>{{ __('product::product.Description') }}</th>
                                    <th>{{ __('product::product.Price') }}</th>
                                    <th>{{ __('product::product.Image') }}</th>
                                    <th class="text-center">{{ __('product::product.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($works as $work)
                                    <tr>
                                        <td>{{ $work->title }}</td>
                                        <td>{{ $work->description ?? __('product::product.No Description') }}</td>
                                        <td>${{ number_format($work->price, 2) }}</td>
                                        <td><img src="{{ $work->image_path }}" width="75" height="75"></td>
                                        <td class="text-center">
                                            <a href="javascript:;" class="btn btn-sm btn-info btn-modal-view"
                                                data-url="{{ route('admin.work.edit', ['work' => $work->id]) }}">{{ __('product::product.Edit') }}</a>
                                            <a href="javascript:;" class="btn btn-sm btn-danger delete-btn"
                                                data-url="{{ route('admin.work.destroy', ['work' => $work->id]) }}">
                                                {{ __('product::product.Delete') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            {{ __('product::product.No works available') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $works->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
