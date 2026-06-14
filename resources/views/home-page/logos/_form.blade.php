@php $logo = $logo ?? null; @endphp
<div class="card"><div class="card-body row">
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Name') }} *</label><input type="text" name="name" class="form-control" value="{{ old('name', $logo?->name) }}" required></div>
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Partner Type') }} *</label>
<select name="partner_type" class="form-control" required>
<option value="college" {{ old('partner_type', $logo?->partner_type) === 'college' ? 'selected' : '' }}>{{ __('College') }}</option>
<option value="company" {{ old('partner_type', $logo?->partner_type) === 'company' ? 'selected' : '' }}>{{ __('Company') }}</option>
<option value="industry_logos" {{ old('partner_type', $logo?->partner_type) === 'industry_logos' ? 'selected' : '' }}>{{ __('Industry Logos') }}</option>
</select></div>
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Website URL') }}</label><input type="url" name="website_url" class="form-control" value="{{ old('website_url', $logo?->website_url) }}"></div>
<div class="col-md-6 mb-3"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo" class="form-control"></div>
<div class="col-md-4 mb-3"><label class="form-label">{{ __('Sort Order') }}</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $logo?->sort_order ?? 0) }}"></div>
<div class="col-md-4 mb-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', $logo?->is_active) ? 'checked' : '' }}><label for="is_active" class="form-check-label">{{ __('Publish') }}</label></div></div>
</div></div>
