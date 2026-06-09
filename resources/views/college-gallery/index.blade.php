@extends($layout_path)
@section('title', $app_setting['name'] . ' | ' . __('College MOU & Gallery'))
@section('header-title')<h3 class="title">{{ __('College MOU & Gallery') }}</h3>@endsection
@section('content')
<div class="app-main-outer"><div class="app-main-inner">
<div class="card"><div class="card-body">
    <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">
        <a href="{{ route('college-gallery.create') }}" class="btn btn-primary btn-sm rounded-pill"><i class="fa-solid fa-plus me-1"></i> {{ __('Add Gallery Item') }}</a>
        <form action="{{ route('college-gallery.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <select name="section_type" class="form-select form-select-sm">
                <option value="">{{ __('All Sections') }}</option>
                @foreach($sections as $section)
                    <option value="{{ $section->value }}" {{ request('section_type') == $section->value ? 'selected' : '' }}>{{ __($section->label()) }}</option>
                @endforeach
            </select>
            <select name="college_id" class="form-select form-select-sm">
                <option value="">{{ __('All Colleges') }}</option>
                @foreach($colleges as $college)
                    <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>{{ $college->name }}</option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
            <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr>
                <th>#</th><th>{{ __('Preview') }}</th><th>{{ __('Title') }}</th><th>{{ __('Section') }}</th>
                <th>{{ __('College') }}</th><th>{{ __('Type') }}</th><th>{{ __('Order') }}</th><th>{{ __('Status') }}</th><th>{{ __('Action') }}</th>
            </tr></thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->media)
                            @if($item->media->type?->value === 'video')
                                <span class="badge bg-dark"><i class="fa-solid fa-video"></i></span>
                            @else
                                <img src="{{ $item->mediaPath }}" alt="" style="height:40px;width:60px;object-fit:cover" class="rounded">
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td><strong>{{ $item->title }}</strong></td>
                    <td><span class="badge bg-light text-dark">{{ __($item->section_type?->label()) }}</span></td>
                    <td>{{ $item->college?->name ?? '-' }}</td>
                    <td>{{ ucfirst($item->media?->type?->value ?? '-') }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>
                        @if($item->is_active)
                            <span class="badge bg-success">{{ __('Published') }}</span>
                        @else
                            <span class="badge bg-secondary">{{ __('Draft') }}</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('college-gallery.edit', $item) }}" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)" onclick="deleteAction('{{ route('college-gallery.destroy', $item) }}')" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-danger">{{ __('No gallery items found') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
</div></div></div></div>
@endsection
