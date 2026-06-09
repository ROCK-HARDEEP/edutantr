<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Job Title') }} <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $jobPost->title ?? '') }}" required>
        @error('title')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
        <select name="job_category_id" class="form-select" required>
            <option value="">{{ __('Select Category') }}</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('job_category_id', $jobPost->job_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('job_category_id')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Company Name') }}</label>
        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $jobPost->company_name ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Location') }}</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $jobPost->location ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Job Type') }} <span class="text-danger">*</span></label>
        <select name="job_type" class="form-select" required>
            @foreach($jobTypes as $type)
                <option value="{{ $type->value }}" {{ old('job_type', isset($jobPost) ? $jobPost->job_type?->value : 'full_time') == $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Salary Range') }}</label>
        <input type="text" name="salary_range" class="form-control" placeholder="e.g. $50,000 - $70,000" value="{{ old('salary_range', $jobPost->salary_range ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ __('Application Deadline') }}</label>
        <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline', isset($jobPost) && $jobPost->application_deadline ? $jobPost->application_deadline->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
        <div id="job-description-editor" class="bg-white" style="min-height: 200px">{!! old('description', $jobPost->description ?? '') !!}</div>
        <input type="hidden" id="job-description-input" name="description" value="{{ old('description', $jobPost->description ?? '') }}">
        @error('description')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ __('Requirements') }}</label>
        <div id="job-requirements-editor" class="bg-white" style="min-height: 180px">{!! old('requirements', $jobPost->requirements ?? '') !!}</div>
        <input type="hidden" id="job-requirements-input" name="requirements" value="{{ old('requirements', $jobPost->requirements ?? '') }}">
        @error('requirements')<p class="text-danger">{{ $message }}</p>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">{{ __('Status') }}</label>
        <select name="status" class="form-select">
            @foreach($statuses as $status)
                <option value="{{ $status->value }}" {{ old('status', isset($jobPost) ? $jobPost->status?->value : 'open') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ old('is_active', isset($jobPost) ? $jobPost->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ __('Publish Job') }}</label>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toolbarOptions = [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['blockquote'],
            [{ 'align': [] }],
            ['link'],
            ['clean']
        ];

        const quillDescription = new Quill('#job-description-editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions },
            placeholder: @json(__('Describe the role, responsibilities, and what makes this opportunity great...'))
        });

        const quillRequirements = new Quill('#job-requirements-editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions },
            placeholder: @json(__('List skills, experience, and qualifications required for this role...'))
        });

        function syncEditor(quill, inputId) {
            document.getElementById(inputId).value = quill.root.innerHTML;
        }

        quillDescription.on('text-change', function () {
            syncEditor(quillDescription, 'job-description-input');
        });

        quillRequirements.on('text-change', function () {
            syncEditor(quillRequirements, 'job-requirements-input');
        });

        const form = document.querySelector('form[action*="job-post"]');
        if (form) {
            form.addEventListener('submit', function (e) {
                syncEditor(quillDescription, 'job-description-input');
                syncEditor(quillRequirements, 'job-requirements-input');

                if (!quillDescription.getText().trim()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: @json(__('Description is required')),
                        text: @json(__('Please add a job description before submitting.'))
                    });
                }
            });
        }
    });
</script>
@endpush
