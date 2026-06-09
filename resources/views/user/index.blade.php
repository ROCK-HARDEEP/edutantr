@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('User List'))

@section('header-title')
    <h3 class="title">{{ __('Students Management') }}</h3>
@endsection

@section('content')
    <!-- ****Body-Section***** -->
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <nav aria-label="breadcrumb" class="modern-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-house"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ __('Students') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row" id="deleteTableItem">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">

                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <a href="{{ route('user.create') }}"
                                        class="btn btn-shadow btn-outline-primary rounded-pill">
                                        {{ __('+ New Student') }}
                                    </a>
                                    <button type="button" class="btn btn-shadow btn-outline-success rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                                        <i class="bi bi-upload me-1"></i> {{ __('Import Students') }}
                                    </button>
                                    <a href="{{ route('user.import.sample') }}"
                                        class="btn btn-shadow btn-outline-secondary rounded-pill">
                                        <i class="bi bi-download me-1"></i> {{ __('Download Sample') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('user.index') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search ..." name="cat_search"
                                                value="{{ request('cat_search') }}">
                                            <button class="btn btn-primary rounded ms-2 shadow-sm" type="submit"
                                                style="width: 50px; height: 50px">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('ID') }}</strong></th>
                                            <th><strong>{{ __('Name') }}</strong></th>
                                            <th><strong>{{ __('Email') }}</strong></th>
                                            <th><strong>{{ __('Phone') }}</strong></th>
                                            <th><strong>{{ __('Account Verified') }}</strong></th>
                                            <th><strong>{{ __('Status') }}</strong></th>
                                            @if (Auth::user()->hasRole('admin') ||
                                                    Auth::user()->hasRole('organization') ||
                                                    Auth::user()->is_admin ||
                                                    Auth::user()->is_org)
                                                <th><strong>{{ __('Action') }}</strong></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ generateID($user->id) }}</td>
                                                <td class="tableId">
                                                    <div class="d-flex justify-content-start align-items-center gap-2">
                                                        <div class="d-flex justify-content-start align-items-center"
                                                            style="width: 30px; height: 30px">
                                                            <img src="{{ $user->profilePicturePath }}"
                                                                class="w-100 h-100 object-fit-cover rounded-circle">
                                                        </div>
                                                        <p class="priceDis">{{ $user->name }}</p>
                                                    </div>
                                                </td>
                                                <td class="tableId">{{ $user->email }}</td>
                                                <td class="tableId">{{ $user->phone }}</td>
                                                <td class="tableCustomar">
                                                    @if ($user->email_verified_at || $user->is_active)
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ __('Yes') }}</span>
                                                    @else
                                                        <span
                                                            class="badge rounded-pill text-bg-danger">{{ __('No') }}</span>
                                                    @endif
                                                </td>
                                                <td class="tableStatus">
                                                    @if ($user->trashed())
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Deleted') }}</span>
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
                                                @if (Auth::user()->hasRole('admin') ||
                                                        Auth::user()->hasRole('organization') ||
                                                        Auth::user()->is_admin ||
                                                        Auth::user()->is_org)
                                                    <td class="tableAction">
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if ($user->trashed())
                                                                <a class="drop-item tooltip-custom"
                                                                    href="{{ route('user.restore', $user->id) }}"
                                                                    target="_blank">
                                                                    <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                                    <span
                                                                        class="tooltip-text">{{ __('Restore User') }}</span>
                                                                </a>
                                                            @else
                                                                <a class="drop-item tooltip-custom"
                                                                    href="{{ route('user.edit', $user->id) }}"
                                                                    target="_blank">
                                                                    <i
                                                                        class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                                    <span class="tooltip-text">{{ __('Edit User') }}</span>
                                                                </a>
                                                                @if (!$user->is_admin && !$user->instructor)
                                                                    <a class="drop-item tooltip-custom"
                                                                        href="{{ route('user.edit', $user->id) }}"
                                                                        target="_blank">
                                                                        <i class="bi bi-person-fill-up me-1 text-dark"></i>
                                                                        <span
                                                                            class="tooltip-text">{{ __('Promote User') }}</span>
                                                                    </a>
                                                                @endif
                                                                @if ($user->id != Auth::user()->id && !$user->is_admin)
                                                                    <a class="drop-item tooltip-custom"
                                                                        href="javascript:void(0)"
                                                                        onclick="deleteAction('{{ route('user.destroy', $user->id) }}')">
                                                                        <i
                                                                            class="bi bi-person-fill-slash me-1 text-danger"></i>
                                                                        <span
                                                                            class="tooltip-text">{{ __('Suspend User') }}</span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">
                                                    <h5 class="text-danger text-center m-0">{{ __('No User Available') }}
                                                    </h5>
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
        </div>

        <!-- ****End-Body-Section**** -->
    </div>

    <div class="modal fade" id="importStudentsModal" tabindex="-1" aria-labelledby="importStudentsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="importStudentsModalLabel">{{ __('Import Students') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            {{ __('Upload a CSV file to create multiple student accounts at once.') }}
                        </p>
                        <div class="alert alert-light border mb-3">
                            <strong>{{ __('Required columns') }}:</strong>
                            <code>name</code>, <code>email</code>, <code>phone</code>, <code>password</code>
                            <br>
                            <strong>{{ __('Optional columns') }}:</strong>
                            <code>is_active</code> (yes/no), <code>team_code</code> (4 characters)
                        </div>
                        <a href="{{ route('user.import.sample') }}" class="btn btn-sm btn-outline-primary mb-3">
                            <i class="bi bi-download me-1"></i> {{ __('Download Sample CSV') }}
                        </a>
                        <div>
                            <label for="importFile" class="form-label fw-semibold">{{ __('CSV File') }} <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="file" id="importFile" class="form-control" accept=".csv,text/csv"
                                required>
                            @error('file')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        @if (session('import_errors'))
                            <div class="alert alert-warning mt-3 mb-0">
                                <strong>{{ __('Import details') }}:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach (session('import_errors') as $importError)
                                        <li>{{ $importError }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="bi bi-upload me-1"></i> {{ __('Import') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('import_errors') || $errors->has('file'))
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const importModal = document.getElementById('importStudentsModal');
                    if (importModal) {
                        bootstrap.Modal.getOrCreateInstance(importModal).show();
                    }
                });
            </script>
        @endpush
    @endif
@endsection
