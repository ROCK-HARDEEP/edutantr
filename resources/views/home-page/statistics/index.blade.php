@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Home Statistics'))
@section('header-title')<h3 class="title">{{ __('Home Statistics') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="card"><div class="card-body">
<div class="mb-3"><a href="{{ route('home-statistic.create') }}" class="btn btn-primary btn-sm rounded-pill">{{ __('Add Statistic') }}</a></div>
<table class="table table-striped"><thead><tr><th>#</th><th>{{ __('Label') }}</th><th>{{ __('Value') }}</th><th>{{ __('Order') }}</th><th>{{ __('Action') }}</th></tr></thead>
<tbody>@forelse($statistics as $s)<tr><td>{{ $s->id }}</td><td>{{ $s->label }}</td><td>{{ $s->value }}{{ $s->suffix }}</td><td>{{ $s->sort_order }}</td>
<td><a href="{{ route('home-statistic.edit', $s) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
<a href="javascript:void(0)" onclick="deleteAction('{{ route('home-statistic.destroy', $s) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>
@empty<tr><td colspan="5" class="text-center text-danger">{{ __('No records found') }}</td></tr>@endforelse</tbody></table>
{{ $statistics->links() }}
</div></div></div></div>
@endsection
