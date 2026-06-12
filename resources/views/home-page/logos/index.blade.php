@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Partner Logos'))
@section('header-title')<h3 class="title">{{ __('Partner Logos') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="card"><div class="card-body">
<div class="mb-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
    <a href="{{ route('partner-logo.create') }}" class="btn btn-primary btn-sm rounded-pill">{{ __('Add Logo') }}</a>
    <span class="text-muted small">{{ __('Up to 5 published company partners fill the hero as full-height portrait columns. Use vertical photos for best results.') }}</span>
</div>
<table class="table table-striped"><thead><tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Type') }}</th><th>{{ __('Order') }}</th><th>{{ __('Action') }}</th></tr></thead>
<tbody>@forelse($logos as $l)<tr><td>{{ $l->id }}</td><td>{{ $l->name }}</td><td>{{ ucfirst($l->partner_type) }}</td><td>{{ $l->sort_order }}</td>
<td><a href="{{ route('partner-logo.edit', $l) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
<a href="javascript:void(0)" onclick="deleteAction('{{ route('partner-logo.destroy', $l) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>
@empty<tr><td colspan="5" class="text-center text-danger">{{ __('No records found') }}</td></tr>@endforelse</tbody></table>
{{ $logos->links() }}
</div></div></div></div>
@endsection
