<div class="modal fade" id="studentCertificateModal" tabindex="-1" aria-labelledby="studentCertificateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="studentCertificateModalLabel">{{ __('Student Certificates') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">
                    {{ __('Upload certificates for') }}: <strong id="certificateStudentName"></strong>
                </p>

                <form id="studentCertificateForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="certificateTitle" class="form-label fw-semibold">{{ __('Certificate Title') }}
                                <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="certificateTitle" class="form-control" maxlength="255"
                                required placeholder="{{ __('e.g. Course Completion Certificate') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="certificateFile" class="form-label fw-semibold">{{ __('Certificate File') }}
                                <span class="text-danger">*</span></label>
                            <input type="file" name="certificate" id="certificateFile" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="text-muted">{{ __('Allowed: PDF, JPG, PNG. Max 10MB') }}</small>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="bi bi-upload me-1"></i> {{ __('Upload Certificate') }}
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <h6 class="fw-semibold mb-3">{{ __('Uploaded Certificates') }}</h6>
                <div id="studentCertificateList" class="list-group"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('studentCertificateModal');
            const form = document.getElementById('studentCertificateForm');
            const list = document.getElementById('studentCertificateList');
            const studentNameEl = document.getElementById('certificateStudentName');
            let currentUserId = null;

            function renderCertificates(certificates) {
                list.innerHTML = '';

                if (!certificates.length) {
                    list.innerHTML =
                        '<div class="text-muted text-center py-3">{{ __('No certificates uploaded yet') }}</div>';
                    return;
                }

                certificates.forEach(function(certificate) {
                    const item = document.createElement('div');
                    item.className =
                        'list-group-item d-flex justify-content-between align-items-center gap-3';
                    item.innerHTML = `
                        <div>
                            <div class="fw-semibold">${certificate.title}</div>
                            <small class="text-muted">${certificate.uploaded_at || ''} · ${(certificate.extension || '').toUpperCase()}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="${certificate.file_url}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-download"></i>
                            </a>
                            <form method="POST" action="{{ url('/student-certificates') }}/${certificate.id}" onsubmit="return confirm('{{ __('Delete this certificate?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    `;
                    list.appendChild(item);
                });
            }

            function loadCertificates(userId) {
                list.innerHTML =
                    '<div class="text-muted text-center py-3">{{ __('Loading certificates...') }}</div>';

                fetch(`{{ url('/user') }}/${userId}/certificates`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => renderCertificates(data.certificates || []))
                    .catch(() => {
                        list.innerHTML =
                            '<div class="text-danger text-center py-3">{{ __('Failed to load certificates') }}</div>';
                    });
            }

            document.querySelectorAll('.open-certificate-modal').forEach(function(button) {
                button.addEventListener('click', function() {
                    currentUserId = this.dataset.userId;
                    studentNameEl.textContent = this.dataset.userName;
                    form.action = `{{ url('/user') }}/${currentUserId}/certificates`;
                    form.reset();
                    loadCertificates(currentUserId);
                    bootstrap.Modal.getOrCreateInstance(modal).show();
                });
            });
        });
    </script>
@endpush
