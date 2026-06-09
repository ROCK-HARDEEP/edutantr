@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Partner Colleges'))
@section('header-title')<h3 class="title">{{ __('Partner Colleges') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="card"><div class="card-body">
<div class="mb-3"><a href="{{ route('partner-college.create') }}" class="btn btn-primary btn-sm rounded-pill">{{ __('Add College') }}</a></div>
<table class="table table-striped"><thead><tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Location') }}</th><th>{{ __('Order') }}</th><th>{{ __('Action') }}</th></tr></thead>
<tbody>@forelse($colleges as $c)<tr><td>{{ $c->id }}</td><td>{{ $c->name }}</td><td>{{ $c->location }}</td><td>{{ $c->sort_order }}</td>
<td><a href="{{ route('partner-college.edit', $c) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
<a href="javascript:void(0)" onclick="deleteAction('{{ route('partner-college.destroy', $c) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>
@empty<tr><td colspan="5" class="text-center text-danger">{{ __('No records found') }}</td></tr>@endforelse</tbody></table>
{{ $colleges->links() }}
</div></div></div></div>
@endsection
