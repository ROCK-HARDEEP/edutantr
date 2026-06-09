@extends('sales.layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Course List'))

@section('header-title')
    <h3 class="title">{{ __('Course List') }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <nav aria-label="breadcrumb" class="modern-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('sales.dashboard') }}">
                                <i class="fa-solid fa-house"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa-solid fa-book"></i>
                            {{ __('Course') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row">
                <div class="col-md-12 my-3">
                    <div class="card shadow-lg border-0 rounded-3 mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">
                                <div>
                                    <h5 class="mb-0">{{ __('All Courses') }}</h5>
                                    <small class="text-muted">{{ __('Browse all available courses') }}</small>
                                </div>
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('sales.courses') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 {{ __('Search course...') }}" name="cat_search"
                                                value="{{ request('cat_search') }}">
                                            <button class="btn btn-primary rounded ms-2 shadow-sm" type="submit"
                                                style="width: 50px; height: 50px">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive-xl">
                                <table class="table table-striped align-middle modern-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Free & Publish') }}</th>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Instructor') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($courses as $course)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration + ($courses->currentPage() - 1) * $courses->perPage() }}</td>
                                                <td>{{ generateID($course->id) }}</td>
                                                <td>
                                                    <span class="badge {{ $course->is_free ? 'bg-success' : 'bg-dark' }}">
                                                        {{ $course->is_free ? __('Free') : __('Paid') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/details/' . $course->id) }}" target="_blank"
                                                        class="d-flex align-items-center text-decoration-none">
                                                        <img src="{{ $course->mediaPath }}"
                                                            class="rounded-circle me-3 shadow-sm"
                                                            style="width:30px; height:30px; object-fit:cover;">
                                                        <span class="fw-semibold text-dark">
                                                            {{ strlen($course->title) > 30 ? substr($course->title, 0, 30) . '...' : $course->title }}
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="fw-bold">
                                                    @if ($app_setting['currency_position'] == 'Left')
                                                        {{ $app_setting['currency_symbol'] }}{{ $course->price ?? $course->regular_price }}
                                                    @else
                                                        {{ $course->price ?? $course->regular_price }}{{ $app_setting['currency_symbol'] }}
                                                    @endif
                                                </td>
                                                <td>{{ $course->instructor?->user?->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($course->is_active == false)
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Pending') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">{{ __('Active') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="drop-item tooltip-custom"
                                                        href="{{ url('/details/' . $course->id) }}" target="_blank">
                                                        <i class="fa-regular fa-eye me-1 text-primary"></i>
                                                        <span class="tooltip-text">{{ __('View Course') }}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger py-4">
                                                    {{ __('No course data found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $courses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
