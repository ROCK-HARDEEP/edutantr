@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Application Details'))
@section('header-title')<h3 class="title">{{ __('Application Review') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="page-title-actions px-3 mb-3">
    <nav aria-label="breadcrumb" class="modern-breadcrumb"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> {{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('job-application.index') }}">{{ __('Applications') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Review') }}</li>
    </ol></nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm"><div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <img src="{{ $application->user->profilePicturePath }}" width="64" height="64" class="rounded-circle object-fit-cover" alt="">
                <div>
                    <h4 class="mb-1">{{ $application->user->name }}</h4>
                    <p class="mb-0 text-muted">{{ $application->user->email }}</p>
                    @if($application->user->phone)<p class="mb-0 text-muted">{{ $application->user->phone }}</p>@endif
                </div>
                <span class="badge {{ $application->status->badgeClass() }} ms-auto fs-6">{{ $application->status->label() }}</span>
            </div>

            <h5 class="mb-3"><i class="fa-solid fa-briefcase me-2 text-primary"></i>{{ __('Applied For') }}</h5>
            <div class="bg-light rounded p-3 mb-4">
                @if($application->jobPost)
                    <h6 class="mb-1">
                        <a href="{{ url('/careers/' . $application->jobPost->id) }}" target="_blank" class="text-decoration-none">
                            {{ $application->jobPost->title }}
                            <i class="fa-solid fa-arrow-up-right-from-square ms-1 small text-muted"></i>
                        </a>
                    </h6>
                    <p class="mb-2 text-muted">
                        {{ $application->jobPost->category?->name }}
                        @if($application->jobPost->company_name) &bull; {{ $application->jobPost->company_name }} @endif
                        @if($application->jobPost->location) &bull; {{ $application->jobPost->location }} @endif
                    </p>
                    <a href="{{ url('/careers/' . $application->jobPost->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="fa-solid fa-briefcase me-1"></i> {{ __('View Job') }}
                    </a>
                @else
                    <h6 class="mb-1 text-muted">{{ __('Job no longer available') }}</h6>
                @endif
                <small class="text-muted d-block mt-2">{{ __('Applied on') }}: {{ $application->created_at->format('M d, Y h:i A') }}</small>
            </div>

            @if($application->cover_letter)
                <h5 class="mb-2"><i class="fa-solid fa-envelope me-2 text-primary"></i>{{ __('Cover Letter') }}</h5>
                <div class="bg-light rounded p-3 mb-4" style="white-space:pre-wrap">{{ $application->cover_letter }}</div>
            @endif

            @if($application->resumeUrl)
                <h5 class="mb-2"><i class="fa-solid fa-file-pdf me-2 text-danger"></i>{{ __('Resume') }}</h5>
                <a href="{{ $application->resumeUrl }}" target="_blank" class="btn btn-outline-primary rounded-pill">
                    <i class="fa-solid fa-download me-1"></i> {{ __('Download Resume') }}
                </a>
            @endif
        </div></div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm sticky-top" style="top:90px"><div class="card-body">
            <h5 class="mb-3">{{ __('Update Status') }}</h5>
            <form action="{{ route('job-application.update', $application) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">{{ __('Application Status') }}</label>
                    <select name="status" class="form-select" required>
                        @foreach($statuses as $st)
                            <option value="{{ $st->value }}" {{ $application->status->value === $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="text-danger">{{ $message }}</p>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Admin Notes') }}</label>
                    <textarea name="admin_notes" class="form-control" rows="4" placeholder="{{ __('Internal notes about this applicant...') }}">{{ old('admin_notes', $application->admin_notes) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill">{{ __('Save Changes') }}</button>
            </form>
            <a href="{{ route('job-application.index') }}" class="btn btn-outline-secondary w-100 rounded-pill mt-2">{{ __('Back to List') }}</a>
        </div></div>
    </div>
</div>
</div></div>
@endsection
