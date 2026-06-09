@php $placement = $placement ?? null; @endphp
<div class="card"><div class="card-body row">
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Student Name') }} *</label><input type="text" name="student_name" class="form-control" value="{{ old('student_name', $placement?->student_name) }}" required></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Company Name') }} *</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name', $placement?->company_name) }}" required></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Role') }}</label><input type="text" name="role" class="form-control" value="{{ old('role', $placement?->role) }}"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Photo') }}</label><input type="file" name="image" class="form-control"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Sort Order') }}</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $placement?->sort_order ?? 0) }}"></div>
<div class="col-md-4 mb-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $placement?->is_active) ? 'checked' : '' }}><label for="is_active" class="form-check-label">{{ __('Publish') }}</label></div></div>
</div></div>
