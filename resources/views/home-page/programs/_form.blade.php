@php $program = $program ?? null; @endphp
<div class="card"><div class="card-body row">
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Title') }} *</label><input type="text" name="title" class="form-control" value="{{ old('title', $program?->title) }}" required></div>
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Subtitle') }}</label><input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $program?->subtitle) }}"></div>
<div class="col-md-12 mb-3"><label class="form-label">{{ __('Description') }}</label><textarea name="description" class="form-control" rows="4">{{ old('description', $program?->description) }}</textarea></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Program Type') }} *</label>
<select name="program_type" class="form-control" required>
<option value="internship" {{ old('program_type', $program?->program_type) === 'internship' ? 'selected' : '' }}>{{ __('Internship') }}</option>
<option value="training" {{ old('program_type', $program?->program_type) === 'training' ? 'selected' : '' }}>{{ __('Training') }}</option>
</select></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('CTA Label') }}</label><input type="text" name="cta_label" class="form-control" value="{{ old('cta_label', $program?->cta_label) }}"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('CTA URL') }}</label><input type="text" name="cta_url" class="form-control" value="{{ old('cta_url', $program?->cta_url) }}"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Sort Order') }}</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $program?->sort_order ?? 0) }}"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Banner Image') }}</label><input type="file" name="image" class="form-control"></div>
<div class="col-md-4 mb-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $program?->is_active) ? 'checked' : '' }}><label for="is_active" class="form-check-label">{{ __('Publish') }}</label></div></div>
</div></div>
