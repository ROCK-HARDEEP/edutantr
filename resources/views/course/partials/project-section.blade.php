<div class="row my-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-1">{{ __('Course Project') }}</h4>
                <p class="text-muted mb-4">
                    {{ __('Add project details and ideas to help students start building their own project. You can also upload a detailed project guide as PDF.') }}
                </p>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="projectTitle" class="form-label fw-semibold">{{ __('Project Title') }}</label>
                        <input type="text" class="form-control" id="projectTitle" name="project_title"
                            value="{{ old('project_title', $project?->title) }}"
                            placeholder="{{ __('e.g. Build a Portfolio Website') }}">
                        @error('project_title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="projectDescriptionEditor" class="form-label fw-semibold">{{ __('Project Description') }}</label>
                        <textarea class="form-control" id="projectDescriptionEditor" name="project_description"
                            placeholder="{{ __('Describe the project goals, requirements, tech stack, and step-by-step ideas...') }}">{{ old('project_description', $project?->description) }}</textarea>
                        @error('project_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="projectPdf" class="form-label fw-semibold">{{ __('Project Guide PDF') }}</label>
                        <input type="file" class="form-control" id="projectPdf" name="project_pdf" accept=".pdf">
                        <small class="text-muted">{{ __('Optional. Upload a detailed project PDF for students. Max 10MB.') }}</small>
                        @error('project_pdf')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror

                        @if (!empty($project?->media))
                            <div class="mt-3 p-3 border rounded bg-light d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                    <a href="{{ $project->pdf_url }}" target="_blank" class="text-decoration-none">
                                        {{ basename($project->media->src) }}
                                    </a>
                                </div>
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" value="1" id="projectRemovePdf"
                                        name="project_remove_pdf">
                                    <label class="form-check-label" for="projectRemovePdf">
                                        {{ __('Remove current PDF') }}
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof ClassicEditor === 'undefined' || !document.querySelector('#projectDescriptionEditor')) {
                return;
            }

            ClassicEditor
                .create(document.querySelector('#projectDescriptionEditor'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
