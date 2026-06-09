@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Job Post'))
@section('header-title')<h3 class="title">{{ __('Edit Job Post') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('job-post.update', $jobPost) }}" method="POST">
@csrf @method('PUT')
<div class="col-md-10 mx-auto"><div class="card"><div class="card-body">
    @include('career.job-post._form', ['jobPost' => $jobPost])
    <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="{{ route('job-post.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Update Job Post') }}</button>
    </div>
</div></div></div>
</form></div></div>
@endsection
