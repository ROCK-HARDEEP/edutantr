@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Job Posts'))
@section('header-title')<h3 class="title">{{ __('Career Portal - Job Posts') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
    <nav aria-label="breadcrumb" class="modern-breadcrumb"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> {{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Job Posts') }}</li>
    </ol></nav>
</div>
<div class="card"><div class="card-body">
    <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">
        <a href="{{ route('job-post.create') }}" class="btn btn-primary btn-sm rounded-pill"><i class="fa-solid fa-plus me-1"></i> {{ __('Create Job Post') }}</a>
        <form action="{{ route('job-post.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">{{ __('All Categories') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm">
                <option value="">{{ __('All Status') }}</option>
                @foreach($statuses as $st)
                    <option value="{{ $st->value }}" {{ request('status') == $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
            <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped align-middle modern-table">
            <thead><tr>
                <th>#</th><th>{{ __('Title') }}</th><th>{{ __('Category') }}</th><th>{{ __('Type') }}</th>
                <th>{{ __('Applications') }}</th><th>{{ __('Status') }}</th><th>{{ __('Deadline') }}</th><th>{{ __('Action') }}</th>
            </tr></thead>
            <tbody>
            @forelse($jobPosts as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>
                        <strong>{{ $job->title }}</strong>
                        @if($job->company_name)<br><small class="text-muted">{{ $job->company_name }}</small>@endif
                    </td>
                    <td>{{ $job->category?->name }}</td>
                    <td><span class="badge bg-light text-dark">{{ $job->job_type?->label() }}</span></td>
                    <td><a href="{{ route('job-application.index', ['job_post_id' => $job->id]) }}" class="badge bg-primary text-decoration-none">{{ $job->applications_count }} {{ __('Applied') }}</a></td>
                    <td>
                        @if($job->status->value === 'open')
                            <span class="badge bg-success">{{ __('Open') }}</span>
                        @else
                            <span class="badge bg-danger">{{ __('Closed') }}</span>
                        @endif
                    </td>
                    <td>{{ $job->application_deadline?->format('M d, Y') ?? '-' }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('job-post.edit', $job) }}" class="text-warning me-2" title="{{ __('Edit') }}"><i class="fa-solid fa-pen-to-square"></i></a>
                        @if($job->status->value === 'open')
                            <a href="{{ route('job-post.close', $job) }}" class="text-secondary me-2" title="{{ __('Close') }}" onclick="return confirm('{{ __('Close this job opening?') }}')"><i class="fa-solid fa-lock"></i></a>
                        @endif
                        <a href="javascript:void(0)" onclick="deleteAction('{{ route('job-post.destroy', $job) }}')" class="text-danger" title="{{ __('Delete') }}"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-danger">{{ __('No job posts found') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $jobPosts->links() }}
</div></div></div></div>
@endsection
