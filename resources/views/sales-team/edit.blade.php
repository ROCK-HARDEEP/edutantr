@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Edit Sales Team'))

@section('header-title')
    <h3 class="title">{{ __('Edit Sales Team') }}</h3>
@endsection

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="row">
                <div class="col-md-12 my-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('sales-team.update', $team) }}" method="POST" id="teamForm">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">{{ __('Team Name') }}</label>
                                        <input type="text" name="name" class="form-control" required
                                            value="{{ old('name', $team->name) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">{{ __('Team Code (4 characters)') }}</label>
                                        <input type="text" name="code" class="form-control" required maxlength="4"
                                            minlength="4" value="{{ old('code', $team->code) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">{{ __('Daily Target (₹)') }}</label>
                                        <input type="number" name="daily_target" class="form-control" min="0"
                                            value="{{ old('daily_target', $team->daily_target) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                                id="is_active" @checked(old('is_active', $team->is_active))>
                                            <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-0">{{ __('Team Members (Counselors)') }}</h5>
                                        <small class="text-muted">{{ __('Leave password blank to keep existing password') }}</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addMember">
                                        <i class="fa-solid fa-plus"></i> {{ __('Add Member') }}
                                    </button>
                                </div>
                                <div id="membersContainer">
                                    @foreach ($team->members as $index => $member)
                                        <div class="row member-row mb-2 align-items-center">
                                            <input type="hidden" name="members[{{ $index }}][id]"
                                                value="{{ $member->id }}">
                                            <div class="col-md-3 mb-2 mb-md-0">
                                                <input type="text" name="members[{{ $index }}][name]"
                                                    class="form-control" value="{{ old("members.{$index}.name", $member->name) }}" required>
                                            </div>
                                            <div class="col-md-3 mb-2 mb-md-0">
                                                <input type="email" name="members[{{ $index }}][email]"
                                                    class="form-control"
                                                    value="{{ old("members.{$index}.email", $member->user?->email) }}" required>
                                            </div>
                                            <div class="col-md-2 mb-2 mb-md-0">
                                                <input type="password" name="members[{{ $index }}][password]"
                                                    class="form-control" placeholder="{{ __('New password') }}" minlength="6">
                                            </div>
                                            <div class="col-md-2 mb-2 mb-md-0">
                                                <div class="form-check">
                                                    <input class="form-check-input leader-check" type="checkbox"
                                                        name="members[{{ $index }}][is_leader]" value="1"
                                                        @checked(old("members.{$index}.is_leader", $member->is_leader))>
                                                    <label class="form-check-label">{{ __('Leader') }}</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="members[{{ $index }}][is_active]" value="1"
                                                        @checked(old("members.{$index}.is_active", $member->is_active))>
                                                    <label class="form-check-label">{{ __('Active') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger remove-member">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Update Team') }}</button>
                                    <a href="{{ route('sales-team.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let memberIndex = {{ $team->members->count() }};
        document.getElementById('addMember').addEventListener('click', function() {
            const container = document.getElementById('membersContainer');
            const row = document.createElement('div');
            row.className = 'row member-row mb-2 align-items-center';
            row.innerHTML = `
                <div class="col-md-3 mb-2 mb-md-0">
                    <input type="text" name="members[${memberIndex}][name]" class="form-control" placeholder="Counselor name" required>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <input type="email" name="members[${memberIndex}][email]" class="form-control" placeholder="Login email" required>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <input type="password" name="members[${memberIndex}][password]" class="form-control" placeholder="Password" required minlength="6">
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <div class="form-check">
                        <input class="form-check-input leader-check" type="checkbox" name="members[${memberIndex}][is_leader]" value="1">
                        <label class="form-check-label">Leader</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="members[${memberIndex}][is_active]" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-member">Remove</button>
                </div>
            `;
            container.appendChild(row);
            memberIndex++;
        });

        document.getElementById('membersContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-member')) {
                e.target.closest('.member-row').remove();
            }
        });

        document.getElementById('membersContainer').addEventListener('change', function(e) {
            if (e.target.classList.contains('leader-check') && e.target.checked) {
                document.querySelectorAll('.leader-check').forEach(cb => {
                    if (cb !== e.target) cb.checked = false;
                });
            }
        });
    </script>
@endpush
