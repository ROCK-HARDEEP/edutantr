@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Job Categories'))
@section('header-title')<h3 class="title">{{ __('Job Categories') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
    <nav aria-label="breadcrumb" class="modern-breadcrumb"><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> {{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Job Categories') }}</li>
    </ol></nav>
</div>
<div class="card"><div class="card-body">
    <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">
        <a href="{{ route('job-category.create') }}" class="btn btn-primary btn-sm rounded-pill"><i class="fa-solid fa-plus me-1"></i> {{ __('Add Category') }}</a>
        <form action="{{ route('job-category.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <table class="table table-striped align-middle modern-table">
        <thead><tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Sort Order') }}</th><th>{{ __('Status') }}</th><th>{{ __('Action') }}</th></tr></thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->sort_order }}</td>
                <td>
                    @if($category->is_active)
                        <span class="badge bg-success">{{ __('Active') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('job-category.edit', $category) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="javascript:void(0)" onclick="deleteAction('{{ route('job-category.destroy', $category) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-danger">{{ __('No categories found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $categories->links() }}
</div></div></div></div>
@endsection
