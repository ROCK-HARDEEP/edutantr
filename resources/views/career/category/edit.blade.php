@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Edit Job Category'))
@section('header-title')<h3 class="title">{{ __('Edit Job Category') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<form action="{{ route('job-category.update', $category) }}" method="POST">
@csrf @method('PUT')
<div class="col-md-8 mx-auto"><div class="card"><div class="card-body">
    <div class="mb-3">
        <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        @error('name')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">{{ __('Sort Order') }}</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}" min="0">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $category->is_active ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
    </div>
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('job-category.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
</div></div></div>
</form></div></div>
@endsection
