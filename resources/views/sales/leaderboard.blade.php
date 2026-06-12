@extends('sales.layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Revenue Leaderboard'))

@section('header-title')
    <h3 class="title">{{ __('Revenue Leaderboard') }}</h3>
@endsection

@push('styles')
    <style>
        .hq-leaderboard {
            background: linear-gradient(135deg, #e8f0fe 0%, #f5f8ff 50%, #eef3ff 100%);
            border-radius: 16px;
            padding: 24px;
            min-height: 100vh;
        }
        .hq-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .hq-title { font-size: 2rem; font-weight: 800; color: #1a3a6b; letter-spacing: 1px; }
        .live-badge { background: #dc3545; color: #fff; font-size: 0.65rem; padding: 2px 8px; border-radius: 4px; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
        .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-tab { border: 2px solid #2b59a8; background: #fff; color: #2b59a8; padding: 8px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .filter-tab.active, .filter-tab:hover { background: #2b59a8; color: #fff; }
        .hq-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(26, 58, 107, 0.08); padding: 24px; height: 100%; }
        .hq-card-dark { background: linear-gradient(135deg, #1a3a6b 0%, #2b59a8 100%); color: #fff; border-radius: 16px; padding: 24px; height: 100%; position: relative; overflow: hidden; }
        .congrats-box { background: #e8f4fd; border-left: 4px solid #2b59a8; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; color: #1a3a6b; }
        .podium { display: flex; align-items: flex-end; justify-content: center; gap: 12px; min-height: 200px; padding-top: 20px; }
        .podium-item { text-align: center; flex: 1; max-width: 140px; }
        .podium-name { font-weight: 700; font-size: 0.85rem; margin-bottom: 8px; color: #1a3a6b; min-height: 40px; }
        .podium-block { border-radius: 8px 8px 0 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; font-weight: 800; }
        .podium-1st { background: #2b59a8; height: 120px; }
        .podium-2nd { background: #94a3b8; height: 90px; }
        .podium-3rd { background: #d4a574; height: 70px; }
        .podium-score { font-size: 1.5rem; font-weight: 800; margin-top: 8px; color: #1a3a6b; }
        .tl-trophy { font-size: 3rem; margin-bottom: 8px; }
        .tl-name { font-size: 2rem; font-weight: 800; text-transform: uppercase; }
        .tl-stats { display: flex; gap: 16px; margin-top: 16px; flex-wrap: wrap; }
        .tl-stat-badge { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; padding: 8px 16px; font-size: 0.8rem; }
        .team-card { background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 12px rgba(26, 58, 107, 0.06); border: 2px solid transparent; height: 100%; }
        .team-card.top-vertical { border-color: #f59e0b; position: relative; }
        .top-vertical-tag { position: absolute; top: -10px; right: 12px; background: #f59e0b; color: #fff; font-size: 0.65rem; font-weight: 700; padding: 2px 10px; border-radius: 4px; }
        .team-name { font-weight: 800; color: #1a3a6b; font-size: 1rem; margin-bottom: 8px; }
        .team-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; }
        .team-pill { background: #e8f0fe; color: #2b59a8; font-size: 0.75rem; padding: 4px 10px; border-radius: 50px; font-weight: 600; }
        .progress-bar-custom { height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 12px; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #2b59a8, #4f8cff); border-radius: 4px; }
        .member-row-item { display: flex; justify-content: space-between; font-size: 0.85rem; padding: 4px 0; border-bottom: 1px solid #f1f5f9; }
        .leaderboard-table th { background: #1a3a6b; color: #fff; font-size: 0.8rem; padding: 10px 12px; }
        .rank-badge { width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; }
        .rank-1 { background: #ffd700; color: #1a3a6b; }
        .rank-2 { background: #c0c0c0; color: #1a3a6b; }
        .rank-3 { background: #cd7f32; color: #fff; }
        .rank-other { background: #e8f0fe; color: #2b59a8; }
        .rank-highlight { background: #fff8e1 !important; }
    </style>
@endpush

@section('content')
    <div class="app-main-outer">
        <div class="app-main-inner p-0">
            <div class="hq-leaderboard" id="leaderboardApp"
                data-fetch-url="{{ route('sales.leaderboard.data') }}"
                data-period="{{ $period }}"
                data-report-date="{{ $reportDate }}">

                <div class="hq-header flex-wrap gap-3">
                    <div>
                        <div class="hq-title">HQ LEADERBOARD</div>
                        <span class="live-badge">LIVE UPDATES</span>
                    </div>
                    <div class="filter-tabs">
                        @foreach (['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'overall' => 'Overall'] as $key => $label)
                            <a href="{{ route('sales.leaderboard', ['period' => $key, 'report_date' => $reportDate]) }}"
                                class="filter-tab {{ $period === $key ? 'active' : '' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-7">
                        <div class="hq-card">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="fa-solid fa-medal text-warning"></i>
                                <strong class="text-primary">Top Performer</strong>
                                <span class="live-badge">LIVE</span>
                            </div>
                            <div class="congrats-box" id="congratsBox">
                                @if ($data['top_performer'])
                                    Congratulations <strong>{{ $data['top_performer']['team_name'] }}</strong>
                                    on reaching the #1 spot with
                                    {{ app(\App\Services\SalesLeaderboardService::class)->formatCurrency($data['top_performer']['revenue']) }}.
                                @else
                                    No payments recorded yet for this period.
                                @endif
                            </div>
                            <div class="podium">
                                @php
                                    $topThree = $data['top_three'];
                                    $podiumOrder = [1 => $topThree[1] ?? null, 0 => $topThree[0] ?? null, 2 => $topThree[2] ?? null];
                                    $podiumClasses = [1 => 'podium-2nd', 0 => 'podium-1st', 2 => 'podium-3rd'];
                                    $podiumLabels = [1 => '2nd', 0 => '1ST', 2 => '3rd'];
                                @endphp
                                @foreach ($podiumOrder as $idx => $performer)
                                    <div class="podium-item">
                                        <div class="podium-name">{{ $performer['team_name'] ?? '-' }}</div>
                                        <div class="podium-block {{ $podiumClasses[$idx] }}">{{ $podiumLabels[$idx] }}</div>
                                        <div class="podium-score">{{ $performer ? '₹' . number_format($performer['revenue'], 0) : '-' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hq-card-dark">
                            <div class="text-center position-relative">
                                <div class="tl-trophy">🏆</div>
                                <div class="small text-white-50 mb-1">Top TL of the Day</div>
                                @if ($data['top_team_leader'])
                                    <div class="tl-name">{{ $data['top_team_leader']['name'] }}</div>
                                    <div class="text-white-50">Vertical – {{ $data['top_team_leader']['team_name'] }}</div>
                                    <div class="tl-stats justify-content-center">
                                        <div class="tl-stat-badge">TARGET: ₹{{ number_format($data['top_team_leader']['team_target'], 0) }}</div>
                                        <div class="tl-stat-badge">ACHIEVED: ₹{{ number_format($data['top_team_leader']['team_achieved'], 0) }}</div>
                                    </div>
                                @else
                                    <div class="tl-name">—</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    @foreach ($data['teams'] as $index => $team)
                        <div class="col-md-6 col-lg-4 col-xl">
                            <div class="team-card {{ $index === 0 && $team['achieved'] > 0 ? 'top-vertical' : '' }}">
                                @if ($index === 0 && $team['achieved'] > 0)
                                    <span class="top-vertical-tag">TOP VERTICAL</span>
                                @endif
                                <div class="team-name">{{ strtoupper($team['name']) }}</div>
                                <div class="team-pills">
                                    <span class="team-pill">Target: ₹{{ number_format($team['daily_target'], 0) }}</span>
                                    <span class="team-pill">Achieved: ₹{{ number_format($team['achieved'], 0) }}</span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: {{ $team['progress'] }}%"></div>
                                </div>
                                @foreach ($team['members'] as $member)
                                    <div class="member-row-item">
                                        <span>{{ strtoupper($member['name']) }}</span>
                                        <span class="text-muted">{{ $member['payments_count'] }} · ₹{{ number_format($member['revenue'], 0) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="hq-card">
                            <h5 class="fw-bold text-primary mb-3">Counselor Leaderboard — {{ ucfirst($period) }}</h5>
                            <div class="table-responsive">
                                <table class="table leaderboard-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Counselor</th>
                                            <th>Team</th>
                                            <th>Payments</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody id="leaderboardBody">
                                        @php $myName = auth()->user()->salesTeamMember?->name; @endphp
                                        @forelse ($data['counselor_leaderboard'] as $row)
                                            <tr class="{{ ($row['counselor_name'] ?? '') === $myName ? 'rank-highlight' : '' }}">
                                                <td><span class="rank-badge rank-{{ $row['rank'] <= 3 ? $row['rank'] : 'other' }}">{{ $row['rank'] }}</span></td>
                                                <td>
                                                    <strong>{{ $row['counselor_name'] }}</strong>
                                                    @if (($row['counselor_name'] ?? '') === $myName)
                                                        <span class="badge bg-primary ms-1">You</span>
                                                    @endif
                                                </td>
                                                <td>{{ $row['team_name'] }}</td>
                                                <td>{{ $row['payments_count'] }}</td>
                                                <td><strong>₹{{ number_format($row['revenue'], 0) }}</strong></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">No data</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="hq-card">
                            <h5 class="fw-bold text-primary mb-3">Daily Team Report</h5>
                            <form method="GET" action="{{ route('sales.leaderboard') }}" class="mb-3">
                                <input type="hidden" name="period" value="{{ $period }}">
                                <input type="date" name="report_date" class="form-control" value="{{ $reportDate }}" onchange="this.form.submit()">
                            </form>
                            <div class="fw-bold text-primary mb-3">
                                Total: ₹{{ number_format($data['daily_report']['total_revenue'], 0) }}
                            </div>
                            @foreach ($data['daily_report']['teams'] as $team)
                                <div class="d-flex justify-content-between small py-1 border-bottom">
                                    <span>{{ $team['name'] }}</span>
                                    <span>₹{{ number_format($team['achieved'], 0) }}/₹{{ number_format($team['daily_target'], 0) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="hq-card mt-3">
                            <h6 class="fw-bold text-primary mb-2">Quick Rankings</h6>
                            @foreach (['daily' => 'Today', 'weekly' => 'This Week', 'monthly' => 'This Month', 'overall' => 'All Time'] as $key => $label)
                                @php $top = $data['rankings'][$key]->first(); @endphp
                                <div class="d-flex justify-content-between small py-1">
                                    <span class="text-muted">{{ $label }}</span>
                                    <span>{{ $top ? $top['counselor_name'] . ' — ₹' . number_format($top['revenue'], 0) : '—' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const app = document.getElementById('leaderboardApp');
            if (!app) return;
            const fetchUrl = app.dataset.fetchUrl;
            const period = app.dataset.period;
            const reportDate = app.dataset.reportDate;
            const myName = @json(auth()->user()->salesTeamMember?->name);

            function formatCurrency(amount) {
                return '₹' + Number(amount).toLocaleString('en-IN', { maximumFractionDigits: 0 });
            }

            function refreshLeaderboard() {
                fetch(`${fetchUrl}?period=${period}&report_date=${reportDate}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.top_performer) {
                        document.getElementById('congratsBox').innerHTML =
                            `Congratulations <strong>${data.top_performer.team_name}</strong> on reaching the #1 spot with ${formatCurrency(data.top_performer.revenue)}.`;
                    }
                    const tbody = document.getElementById('leaderboardBody');
                    if (tbody && data.counselor_leaderboard) {
                        tbody.innerHTML = data.counselor_leaderboard.length ? data.counselor_leaderboard.map(row => `
                            <tr class="${row.counselor_name === myName ? 'rank-highlight' : ''}">
                                <td><span class="rank-badge rank-${row.rank <= 3 ? row.rank : 'other'}">${row.rank}</span></td>
                                <td><strong>${row.counselor_name}</strong>${row.counselor_name === myName ? ' <span class="badge bg-primary ms-1">You</span>' : ''}</td>
                                <td>${row.team_name}</td>
                                <td>${row.payments_count}</td>
                                <td><strong>${formatCurrency(row.revenue)}</strong></td>
                            </tr>
                        `).join('') : '<tr><td colspan="5" class="text-center text-muted py-4">No data</td></tr>';
                    }
                }).catch(() => {});
            }
            setInterval(refreshLeaderboard, 30000);
        })();
    </script>
@endpush
