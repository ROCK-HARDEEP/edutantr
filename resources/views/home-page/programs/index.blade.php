@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Home Programs'))
@section('header-title')<h3 class="title">{{ __('Hero Programs') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="row my-3"><div class="col-12"><div class="card"><div class="card-body">
<div class="d-flex justify-content-between mb-4">
<a href="{{ route('home-program.create') }}" class="btn btn-primary btn-sm rounded-pill"><i class="fa-solid fa-plus me-1"></i>{{ __('Add Program') }}</a>
<form method="GET" class="w-25"><input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}"></form>
</div>
<table class="table table-striped"><thead><tr><th>#</th><th>{{ __('Title') }}</th><th>{{ __('Type') }}</th><th>{{ __('Order') }}</th><th>{{ __('Status') }}</th><th>{{ __('Action') }}</th></tr></thead>
<tbody>
@forelse($programs as $program)
<tr>
<td>{{ $program->id }}</td>
<td>{{ $program->title }}</td>
<td><span class="badge bg-primary">{{ ucfirst($program->program_type) }}</span></td>
<td>{{ $program->sort_order }}</td>
<td>{{ $program->is_active ? __('Active') : __('Inactive') }}</td>
<td>
<a href="{{ route('home-program.edit', $program) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
<a href="javascript:void(0)" onclick="deleteAction('{{ route('home-program.destroy', $program) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
</td>
</tr>
@empty<tr><td colspan="6" class="text-center text-danger">{{ __('No records found') }}</td></tr>@endforelse
</tbody></table>
{{ $programs->links() }}
</div></div></div></div>
</div></div>
@endsection
