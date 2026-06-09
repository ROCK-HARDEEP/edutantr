@extends('sales.layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Sales Dashboard'))

@section('header-title')
    <h3 class="title">{{ __('Sales Dashboard') }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="row card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="col-12">
                    <h3 class="fw-bold mb-1">👋 {{ __('Welcome') }}, {{ auth()->user()->name }}!</h3>
                    <p class="mb-0 text-muted">
                        {{ __('Team') }}: <strong>{{ $member->team?->name ?? '-' }}</strong>
                        @if ($member->is_leader)
                            <span class="badge bg-primary ms-2">{{ __('Team Leader') }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-content bg-gray">
                        <div class="widget-content-wrapper text-white p-3">
                            <div class="widget-heading text-color-blue">{{ $stats['total_students'] }}</div>
                            <div class="widget-subheading text-color-gray">{{ __('My Students') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-content bg-gray">
                        <div class="widget-content-wrapper text-white p-3">
                            <div class="widget-heading text-color-purple">{{ $stats['total_courses'] }}</div>
                            <div class="widget-subheading text-color-gray">{{ __('Available Courses') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-content bg-gray">
                        <div class="widget-content-wrapper text-white p-3">
                            <div class="widget-heading text-color-green">{{ $stats['total_payments'] }}</div>
                            <div class="widget-subheading text-color-gray">{{ __('Total Payments') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-content bg-gray">
                        <div class="widget-content-wrapper text-white p-3">
                            <div class="widget-heading text-color-orange">₹{{ number_format($stats['total_revenue'], 0) }}</div>
                            <div class="widget-subheading text-color-gray">{{ __('Total Revenue') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <a href="{{ route('sales.students.index') }}" class="card text-decoration-none h-100">
                        <div class="card-body">
                            <h5>{{ __('Manage My Students') }}</h5>
                            <p class="text-muted mb-0">{{ __('Add, edit and manage your students') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('sales.courses') }}" class="card text-decoration-none h-100">
                        <div class="card-body">
                            <h5>{{ __('Browse Courses') }}</h5>
                            <p class="text-muted mb-0">{{ __('View all available courses') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('sales.leaderboard') }}" class="card text-decoration-none h-100">
                        <div class="card-body">
                            <h5>{{ __('Revenue Leaderboard') }}</h5>
                            <p class="text-muted mb-0">{{ __('See your ranking among counselors') }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
