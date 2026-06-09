@php $college = $college ?? null; @endphp
<div class="card"><div class="card-body row">
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Name') }} *</label><input type="text" name="name" class="form-control" value="{{ old('name', $college?->name) }}" required></div>
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Location') }}</label><input type="text" name="location" class="form-control" value="{{ old('location', $college?->location) }}"></div>
<div class="col-md-12 mb-3"><label class="form-label">{{ __('Description') }}</label><textarea name="description" class="form-control" rows="3">{{ old('description', $college?->description) }}</textarea></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo" class="form-control"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Sort Order') }}</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $college?->sort_order ?? 0) }}"></div>
<div class="col-md-4 mb-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $college?->is_active) ? 'checked' : '' }}><label for="is_active" class="form-check-label">{{ __('Publish') }}</label></div></div>
</div></div>
