@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Job Applications'))
@section('header-title')<h3 class="title">{{ __('Career Portal - Applications') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="page-title-actions px-3 mb-3">
    <nav aria-label="breadcrumb" class="modern-breadcrumb"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> {{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Job Applications') }}</li>
    </ol></nav>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center">
        <h2 class="mb-0 text-primary">{{ $stats['total'] }}</h2><small class="text-muted">{{ __('Total Applications') }}</small>
    </div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center">
        <h2 class="mb-0 text-warning">{{ $stats['pending'] }}</h2><small class="text-muted">{{ __('Pending Review') }}</small>
    </div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center">
        <h2 class="mb-0 text-info">{{ $stats['shortlisted'] }}</h2><small class="text-muted">{{ __('Shortlisted') }}</small>
    </div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center">
        <h2 class="mb-0 text-success">{{ $stats['hired'] }}</h2><small class="text-muted">{{ __('Hired') }}</small>
    </div></div></div>
</div>

<div class="card"><div class="card-body">
    <form action="{{ route('job-application.index') }}" method="GET" class="d-flex flex-wrap gap-2 mb-4">
        <select name="job_post_id" class="form-select form-select-sm" style="max-width:220px">
            <option value="">{{ __('All Jobs') }}</option>
            @foreach($jobPosts as $jp)
                <option value="{{ $jp->id }}" {{ request('job_post_id') == $jp->id ? 'selected' : '' }}>{{ Str::limit($jp->title, 40) }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select form-select-sm" style="max-width:180px">
            <option value="">{{ __('All Status') }}</option>
            @foreach($statuses as $st)
                <option value="{{ $st->value }}" {{ request('status') == $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
            @endforeach
        </select>
        <input type="text" name="search" class="form-control form-control-sm" style="max-width:220px" placeholder="{{ __('Search applicant...') }}" value="{{ request('search') }}">
        <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i> {{ __('Filter') }}</button>
        <a href="{{ route('job-application.index') }}" class="btn btn-outline-secondary btn-sm">{{ __('Reset') }}</a>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle modern-table">
            <thead><tr>
                <th>#</th><th>{{ __('Applicant') }}</th><th>{{ __('Job Title') }}</th><th>{{ __('Category') }}</th>
                <th>{{ __('Applied On') }}</th><th>{{ __('Status') }}</th><th>{{ __('Action') }}</th>
            </tr></thead>
            <tbody>
            @forelse($applications as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $app->user->profilePicturePath }}" width="36" height="36" class="rounded-circle object-fit-cover" alt="">
                            <div>
                                <strong>{{ $app->user->name }}</strong><br>
                                <small class="text-muted">{{ $app->user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $app->jobPost?->title }}</td>
                    <td>{{ $app->jobPost?->category?->name }}</td>
                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                    <td><span class="badge {{ $app->status->badgeClass() }}">{{ $app->status->label() }}</span></td>
                    <td>
                        <a href="{{ route('job-application.show', $app) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fa-solid fa-eye me-1"></i> {{ __('Review') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-danger py-4">{{ __('No applications found') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $applications->links() }}
</div></div></div></div>
@endsection
