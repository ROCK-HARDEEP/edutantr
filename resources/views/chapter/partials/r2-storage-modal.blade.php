<div class="row">
    <div class="col-md-12 my-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h6 class="mb-1 fw-bold">
                        <i class="fa-solid fa-cloud me-2 text-primary"></i>{{ __('Video Storage') }}
                    </h6>
                    <p class="text-muted mb-0 small">
                        {{ __('Upload and manage videos on Cloudflare R2. Browse your library and copy public links.') }}
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if ($r2Configured ?? false)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#r2StorageModal" id="openR2StorageBtn">
                            <i class="fa-solid fa-folder-open me-1"></i> {{ __('Open Storage Browser') }}
                        </button>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-2">
                            {{ __('R2 not configured — add R2_* keys in .env') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($r2Configured ?? false)
    <div class="modal fade" id="r2StorageModal" tabindex="-1" aria-labelledby="r2StorageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <div>
                        <h5 class="modal-title fw-bold" id="r2StorageModalLabel">
                            <i class="fa-solid fa-cloud me-2"></i>{{ __('Video Storage Library') }}
                        </h5>
                        <small class="text-muted">{{ __('Cloudflare R2 — upload, preview, and copy video links') }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-8">
                                    <label class="form-label fw-semibold">{{ __('Upload Video') }}</label>
                                    <input type="file" class="form-control" id="r2VideoUploadInput"
                                        accept="video/mp4,video/mpeg,video/webm,video/quicktime,video/x-msvideo,video/x-matroska">
                                    <div class="form-text">
                                        {{ __('Supported: MP4, WebM, MOV, AVI, MKV. Max 500 MB.') }}
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex gap-2">
                                    <button type="button" class="btn btn-success flex-grow-1" id="r2UploadBtn"
                                        disabled>
                                        <i class="fa-solid fa-upload me-1"></i> {{ __('Upload to R2') }}
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="r2RefreshBtn"
                                        title="{{ __('Refresh list') }}">
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="progress mt-3 d-none" id="r2UploadProgressWrap" style="height: 8px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    id="r2UploadProgress" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h6 class="mb-0 fw-bold">
                            {{ __('Stored Videos') }}
                            <span class="badge bg-primary ms-1" id="r2VideoCount">0</span>
                        </h6>
                        <div class="input-group" style="max-width: 320px;">
                            <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
                            <input type="text" class="form-control" id="r2SearchInput"
                                placeholder="{{ __('Search by filename...') }}">
                        </div>
                    </div>

                    <div id="r2LoadingState" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="text-muted mt-2 mb-0">{{ __('Loading videos...') }}</p>
                    </div>

                    <div id="r2EmptyState" class="text-center py-5 d-none">
                        <i class="fa-solid fa-film fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">{{ __('No videos found. Upload your first video above.') }}</p>
                    </div>

                    <div class="row g-3" id="r2VideoGrid"></div>
                </div>
            </div>
        </div>
    </div>
@endif

@push('styles')
    @once
        <style>
            #r2VideoGrid .r2-video-card {
                background: #fff;
                border-radius: 12px;
                border: 1px solid #e9ecef;
                overflow: hidden;
                height: 100%;
                transition: box-shadow 0.2s ease;
            }

            #r2VideoGrid .r2-video-card:hover {
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            }

            #r2VideoGrid .r2-video-preview {
                background: #111;
                aspect-ratio: 16 / 9;
                width: 100%;
            }

            #r2VideoGrid .r2-video-preview video {
                width: 100%;
                height: 100%;
                object-fit: contain;
                background: #000;
            }

            #r2VideoGrid .r2-video-meta {
                font-size: 0.8rem;
                color: #6c757d;
            }

            #r2VideoGrid .r2-video-url {
                font-size: 0.75rem;
                word-break: break-all;
                background: #f8f9fa;
                border-radius: 6px;
                padding: 6px 8px;
                max-height: 48px;
                overflow: hidden;
            }
        </style>
    @endonce
@endpush

@push('scripts')
    @once
        <script>
            (function() {
                const modal = document.getElementById('r2StorageModal');
                if (!modal) return;

                const listUrl = @json(route('storage.videos.index'));
                const uploadUrl = @json(route('storage.videos.store'));
                const csrfToken = @json(csrf_token());

                let allVideos = [];

                const grid = document.getElementById('r2VideoGrid');
                const loadingState = document.getElementById('r2LoadingState');
                const emptyState = document.getElementById('r2EmptyState');
                const videoCount = document.getElementById('r2VideoCount');
                const searchInput = document.getElementById('r2SearchInput');
                const uploadInput = document.getElementById('r2VideoUploadInput');
                const uploadBtn = document.getElementById('r2UploadBtn');
                const refreshBtn = document.getElementById('r2RefreshBtn');
                const uploadProgressWrap = document.getElementById('r2UploadProgressWrap');
                const uploadProgress = document.getElementById('r2UploadProgress');

                function showToast(icon, title) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2800,
                        timerProgressBar: true,
                    });
                    Toast.fire({ icon, title });
                }

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                function setLoading(isLoading) {
                    loadingState.classList.toggle('d-none', !isLoading);
                    if (isLoading) {
                        grid.innerHTML = '';
                        emptyState.classList.add('d-none');
                    }
                }

                function renderVideos(videos) {
                    grid.innerHTML = '';
                    videoCount.textContent = videos.length;

                    if (!videos.length) {
                        emptyState.classList.remove('d-none');
                        return;
                    }

                    emptyState.classList.add('d-none');

                    videos.forEach((video) => {
                        const col = document.createElement('div');
                        col.className = 'col-12 col-sm-6 col-lg-4 col-xl-3';

                        const card = document.createElement('div');
                        card.className = 'r2-video-card';

                        const preview = document.createElement('div');
                        preview.className = 'r2-video-preview';
                        const videoEl = document.createElement('video');
                        videoEl.src = video.url;
                        videoEl.controls = true;
                        videoEl.preload = 'metadata';
                        preview.appendChild(videoEl);

                        const body = document.createElement('div');
                        body.className = 'p-3';
                        body.innerHTML = `
                            <div class="fw-semibold text-truncate mb-1"></div>
                            <div class="r2-video-meta mb-2"></div>
                            <div class="r2-video-url mb-2"></div>
                        `;
                        body.querySelector('.fw-semibold').textContent = video.name;
                        body.querySelector('.fw-semibold').title = video.name;
                        body.querySelector('.r2-video-meta').innerHTML =
                            `<span>${escapeHtml(video.size_human)}</span><span class="mx-1">·</span><span>${escapeHtml(video.last_modified_human)}</span>`;
                        const urlBox = body.querySelector('.r2-video-url');
                        urlBox.textContent = video.url;
                        urlBox.title = video.url;

                        const copyBtn = document.createElement('button');
                        copyBtn.type = 'button';
                        copyBtn.className = 'btn btn-sm btn-outline-primary w-100';
                        copyBtn.innerHTML = '<i class="fa-regular fa-copy me-1"></i> {{ __('Copy Link') }}';
                        copyBtn.addEventListener('click', () => copyLink(video.url, copyBtn));

                        body.appendChild(copyBtn);
                        card.appendChild(preview);
                        card.appendChild(body);
                        col.appendChild(card);
                        grid.appendChild(col);
                    });
                }

                function filterVideos() {
                    const query = (searchInput?.value || '').trim().toLowerCase();
                    const filtered = query
                        ? allVideos.filter((v) => v.name.toLowerCase().includes(query))
                        : allVideos;
                    renderVideos(filtered);
                }

                async function copyLink(url, btn) {
                    try {
                        await navigator.clipboard.writeText(url);
                        const original = btn.innerHTML;
                        btn.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('Copied!') }}';
                        btn.classList.replace('btn-outline-primary', 'btn-success');
                        setTimeout(() => {
                            btn.innerHTML = original;
                            btn.classList.replace('btn-success', 'btn-outline-primary');
                        }, 2000);
                        showToast('success', '{{ __('Link copied to clipboard') }}');
                    } catch (e) {
                        const temp = document.createElement('textarea');
                        temp.value = url;
                        document.body.appendChild(temp);
                        temp.select();
                        document.execCommand('copy');
                        document.body.removeChild(temp);
                        showToast('success', '{{ __('Link copied to clipboard') }}');
                    }
                }

                function loadVideos() {
                    setLoading(true);

                    fetch(listUrl, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                        .then((res) => res.json())
                        .then((response) => {
                            allVideos = response.data?.videos || [];
                            filterVideos();
                        })
                        .catch(() => {
                            allVideos = [];
                            renderVideos([]);
                            showToast('error', '{{ __('Failed to load videos') }}');
                        })
                        .finally(() => setLoading(false));
                }

                function uploadVideo() {
                    const file = uploadInput?.files?.[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('video', file);
                    formData.append('_token', csrfToken);

                    uploadBtn.disabled = true;
                    uploadProgressWrap.classList.remove('d-none');
                    uploadProgress.style.width = '30%';

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', uploadUrl);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.setRequestHeader('Accept', 'application/json');

                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            const percent = Math.round((e.loaded / e.total) * 100);
                            uploadProgress.style.width = percent + '%';
                        }
                    });

                    xhr.onload = () => {
                        uploadBtn.disabled = false;
                        uploadProgressWrap.classList.add('d-none');
                        uploadProgress.style.width = '0%';
                        uploadInput.value = '';

                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            showToast('error', '{{ __('Upload failed') }}');
                            return;
                        }

                        if (xhr.status >= 200 && xhr.status < 300) {
                            showToast('success', response.message || '{{ __('Video uploaded') }}');
                            loadVideos();
                        } else {
                            showToast('error', response.message || '{{ __('Upload failed') }}');
                        }
                    };

                    xhr.onerror = () => {
                        uploadBtn.disabled = false;
                        uploadProgressWrap.classList.add('d-none');
                        showToast('error', '{{ __('Upload failed') }}');
                    };

                    xhr.send(formData);
                }

                uploadInput?.addEventListener('change', () => {
                    uploadBtn.disabled = !uploadInput.files?.length;
                });

                uploadBtn?.addEventListener('click', uploadVideo);
                refreshBtn?.addEventListener('click', loadVideos);
                searchInput?.addEventListener('input', filterVideos);

                modal.addEventListener('shown.bs.modal', loadVideos);
            })();
        </script>
    @endonce
@endpush
