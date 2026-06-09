@php $item = $item ?? null; @endphp
<div class="card"><div class="card-body row">
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $item?->title) }}" required>
        @error('title')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Section') }} <span class="text-danger">*</span></label>
        <select name="section_type" class="form-select" required>
            @foreach($sections as $section)
                <option value="{{ $section->value }}" {{ old('section_type', $item?->section_type?->value ?? 'workshop') == $section->value ? 'selected' : '' }}>{{ __($section->label()) }}</option>
            @endforeach
        </select>
        @error('section_type')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('College') }}</label>
        <select name="partner_college_id" class="form-select">
            <option value="">{{ __('Select College') }}</option>
            @foreach($colleges as $college)
                <option value="{{ $college->id }}" {{ old('partner_college_id', $item?->partner_college_id) == $college->id ? 'selected' : '' }}>{{ $college->name }}</option>
            @endforeach
        </select>
        @error('partner_college_id')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Event Date') }}</label>
        <input type="date" name="event_date" class="form-control" value="{{ old('event_date', $item?->event_date?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('Description') }}</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $item?->description) }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Image / Video') }} @if(!$item)<span class="text-danger">*</span>@endif</label>
        <input type="file" name="media" class="form-control" accept="image/*,video/*" {{ $item ? '' : 'required' }}>
        <small class="text-muted">{{ __('Supported: JPEG, PNG, GIF, WebP, MP4, WebM (max 50MB)') }}</small>
        @if($item?->media)
            <div class="mt-2">
                @if($item->media->type?->value === 'video')
                    <video src="{{ $item->mediaPath }}" controls style="max-height:120px;max-width:200px"></video>
                @else
                    <img src="{{ $item->mediaPath }}" alt="" style="max-height:80px;max-width:120px;object-fit:cover" class="rounded">
                @endif
            </div>
        @endif
        @error('media')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ __('Sort Order') }}</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $item?->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">{{ __('Publish') }}</label>
        </div>
    </div>
</div></div>
