@extends('sales.layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('My Students'))

@section('header-title')
    <h3 class="title">{{ __('My Students') }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                        <a href="{{ route('sales.students.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> {{ __('Add Student') }}
                        </a>
                        <form action="{{ route('sales.students.index') }}" method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control"
                                placeholder="{{ __('Search students...') }}" value="{{ $search }}">
                            <button type="submit" class="btn btn-outline-primary">{{ __('Search') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Verified') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $user->profilePicturePath }}" width="32" height="32" class="rounded-circle">
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if ($user->email_verified_at || $user->is_active)
                                                <span class="badge bg-success">{{ __('Yes') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('No') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('sales.students.edit', $user) }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('sales.students.destroy', $user) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('{{ __('Remove this student?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            {{ __('No students yet.') }}
                                            <a href="{{ route('sales.students.create') }}">{{ __('Add your first student') }}</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
