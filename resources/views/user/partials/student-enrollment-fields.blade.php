<div class="mt-5">
    <h6 class="fw-bold mb-3">{{ __('Course & Sales Details') }}</h6>
    <div class="row g-4">
        <div class="col-md-4">
            <label class="form-label fw-semibold">{{ __('Course') }}</label>
            <select name="course_id" class="form-select rounded-3">
                <option value="">{{ __('Select Course') }}</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ (string) old('course_id', $selectedCourseId ?? '') === (string) $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                        @if (!is_null($course->price))
                            ({{ $app_setting['currency_symbol'] ?? '₹' }}{{ number_format($course->price, 0) }})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label fw-semibold">{{ __('Sales Team') }}</label>
            <select name="sales_team_id" class="form-select rounded-3">
                <option value="">{{ __('Select Team') }}</option>
                @foreach ($salesTeams as $team)
                    <option value="{{ $team->id }}"
                        {{ (string) old('sales_team_id', $selectedSalesTeamId ?? '') === (string) $team->id ? 'selected' : '' }}>
                        {{ $team->name }} ({{ $team->code }})
                    </option>
                @endforeach
            </select>
            @error('sales_team_id')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label fw-semibold">{{ __('Payment Status') }}</label>
            <select name="payment_status" class="form-select rounded-3">
                <option value="unpaid" {{ old('payment_status', $paymentStatus ?? 'unpaid') === 'unpaid' ? 'selected' : '' }}>
                    {{ __('Unpaid') }}
                </option>
                <option value="paid" {{ old('payment_status', $paymentStatus ?? 'unpaid') === 'paid' ? 'selected' : '' }}>
                    {{ __('Paid') }}
                </option>
            </select>
            <small class="text-muted d-block mt-1">
                {{ __('Paid enrolls the student in the selected course.') }}
            </small>
            @error('payment_status')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
