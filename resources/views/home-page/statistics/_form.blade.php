@php $statistic = $statistic ?? null; @endphp
<div class="card"><div class="card-body row">
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Label') }} *</label><input type="text" name="label" class="form-control" value="{{ old('label', $statistic?->label) }}" placeholder="Students Trained" required></div>
<div class="col-md-3 mb-3"><label class="form-label">{{ __('Value') }} *</label><input type="text" name="value" class="form-control" value="{{ old('value', $statistic?->value) }}" placeholder="5000" required></div>
<div class="col-md-3 mb-3"><label class="form-label">{{ __('Suffix') }}</label><input type="text" name="suffix" class="form-control" value="{{ old('suffix', $statistic?->suffix) }}" placeholder="+"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Icon class') }}</label><input type="text" name="icon" class="form-control" value="{{ old('icon', $statistic?->icon) }}" placeholder="bi-mortarboard"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Sort Order') }}</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $statistic?->sort_order ?? 0) }}"></div>
<div class="col-md-4 mb-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $statistic?->is_active ?? true) ? 'checked' : '' }}><label for="is_active" class="form-check-label">{{ __('Publish') }}</label></div></div>
</div></div>
