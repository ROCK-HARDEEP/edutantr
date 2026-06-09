@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('Placements'))
@section('header-title')<h3 class="title">{{ __('Placements Achieved') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="card"><div class="card-body">
<div class="mb-3"><a href="{{ route('home-placement.create') }}" class="btn btn-primary btn-sm rounded-pill">{{ __('Add Placement') }}</a></div>
<table class="table table-striped"><thead><tr><th>#</th><th>{{ __('Student') }}</th><th>{{ __('Company') }}</th><th>{{ __('Role') }}</th><th>{{ __('Action') }}</th></tr></thead>
<tbody>@forelse($placements as $p)<tr><td>{{ $p->id }}</td><td>{{ $p->student_name }}</td><td>{{ $p->company_name }}</td><td>{{ $p->role }}</td>
<td><a href="{{ route('home-placement.edit', $p) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
<a href="javascript:void(0)" onclick="deleteAction('{{ route('home-placement.destroy', $p) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>
@empty<tr><td colspan="5" class="text-center text-danger">{{ __('No records found') }}</td></tr>@endforelse</tbody></table>
{{ $placements->links() }}
</div></div></div></div>
@endsection
