@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Sales Teams'))

@section('header-title')
    <h3 class="title">{{ __('Sales Teams') }}</h3>
@endsection

@section('content')
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
                            {{ __('Sales Teams') }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12 my-3">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    @can('sales_team.create')
                                        <a href="{{ route('sales-team.create') }}"
                                            class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                            <i class="fa-solid fa-plus me-1"></i> {{ __('New Team') }}
                                        </a>
                                    @endcan
                                    <a href="{{ route('revenue-leaderboard.index') }}"
                                        class="btn btn-outline-primary btn-sm px-4 py-2 rounded-pill">
                                        <i class="fa-solid fa-chart-line me-1"></i> {{ __('Leaderboard') }}
                                    </a>
                                </div>
                                <form action="{{ route('sales-team.index') }}" method="GET" class="w-auto">
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded ps-4" placeholder="Search team..."
                                            name="search" value="{{ request('search') }}">
                                        <button class="btn btn-primary rounded ms-2" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Team Name') }}</th>
                                            <th>{{ __('Code') }}</th>
                                            <th>{{ __('Daily Target') }}</th>
                                            <th>{{ __('Members') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($teams as $team)
                                            <tr>
                                                <td>{{ $teams->firstItem() + $loop->index }}</td>
                                                <td><strong>{{ $team->name }}</strong></td>
                                                <td><span class="badge bg-primary">{{ $team->code }}</span></td>
                                                <td>₹{{ number_format($team->daily_target, 0) }}</td>
                                                <td>{{ $team->members_count }}</td>
                                                <td>
                                                    @if ($team->is_active)
                                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('sales_team.edit')
                                                        <a href="{{ route('sales-team.edit', $team) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                    @endcan
                                                    @can('sales_team.destroy')
                                                        <form action="{{ route('sales-team.destroy', $team) }}" method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Delete this team?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">{{ __('No teams found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $teams->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
