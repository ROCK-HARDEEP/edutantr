<template>
    <section class="py-4 gallery-page" style="background: #F1F5F9; min-height: 70vh;">
        <div class="container">
            

            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="bg-white rounded-3 p-3 shadow-sm filter-panel">
                        <h5 class="fw-bold mb-3">{{ $t('Filters') }}</h5>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('Search by College Name') }}</label>
                            <input
                                v-model="filters.search"
                                type="text"
                                class="form-control"
                                :placeholder="$t('College name...')"
                                @keyup.enter="applyFilters"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('College') }}</label>
                            <select v-model="filters.college_id" class="form-select" @change="applyFilters">
                                <option value="">{{ $t('All Colleges') }}</option>
                                <option v-for="college in colleges" :key="college.id" :value="college.id">{{ college.name }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('Section') }}</label>
                            <select v-model="filters.section_type" class="form-select" @change="applyFilters">
                                <option value="">{{ $t('All Sections') }}</option>
                                <option v-for="section in sections" :key="section.value" :value="section.value">{{ section.label }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('Media Type') }}</label>
                            <select v-model="filters.media_type" class="form-select" @change="applyFilters">
                                <option value="">{{ $t('All Media') }}</option>
                                <option value="image">{{ $t('Images') }}</option>
                                <option value="video">{{ $t('Videos') }}</option>
                            </select>
                        </div>
                        <button class="btn btn-outline-danger btn-sm w-100" @click="resetFilters">{{ $t('Reset') }}</button>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div v-if="loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>

                    <div v-else-if="viewMode === 'grouped' && groupedSections.length === 0" class="bg-white rounded-3 p-5 text-center shadow-sm">
                        <i class="bi bi-images fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">{{ $t('No gallery items found') }}</h5>
                    </div>

                    <div v-else-if="viewMode === 'list' && items.length === 0" class="bg-white rounded-3 p-5 text-center shadow-sm">
                        <i class="bi bi-images fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">{{ $t('No gallery items found') }}</h5>
                    </div>

                    <template v-else-if="viewMode === 'grouped'">
                        <div v-for="section in groupedSections" :key="section.section_type" class="mb-5">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="fw-bold section-title mb-0">
                                    <i class="bi bi-collection me-2 text-primary"></i>{{ section.section_label }}
                                </h4>
                                <span class="badge bg-primary-subtle text-primary">{{ section.count }} {{ $t('items') }}</span>
                            </div>
                            <div class="row g-3">
                                <div v-for="item in section.items" :key="item.id" class="col-sm-6 col-md-4">
                                    <GalleryCard :item="item" @open="openPreview" />
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <div class="row g-3">
                            <div v-for="item in items" :key="item.id" class="col-sm-6 col-md-4">
                                <GalleryCard :item="item" @open="openPreview" />
                            </div>
                        </div>

                        <nav v-if="pagination.last_page > 1" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <button class="page-link" @click="fetchList(pagination.current_page - 1)">{{ $t('Previous') }}</button>
                                </li>
                                <li v-for="page in pagination.last_page" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                    <button class="page-link" @click="fetchList(page)">{{ page }}</button>
                                </li>
                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <button class="page-link" @click="fetchList(pagination.current_page + 1)">{{ $t('Next') }}</button>
                                </li>
                            </ul>
                        </nav>
                    </template>
                </div>
            </div>
        </div>

        <div v-if="previewItem" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.7);" @click.self="closePreview">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-0">
                        <div>
                            <h5 class="modal-title fw-bold">{{ previewItem.title }}</h5>
                            <small v-if="previewItem.college?.name" class="text-muted">{{ previewItem.college.name }}</small>
                        </div>
                        <button type="button" class="btn-close" @click="closePreview"></button>
                    </div>
                    <div class="modal-body p-0">
                        <video v-if="previewItem.is_video" :src="previewItem.media_url" controls class="w-100" style="max-height: 70vh;"></video>
                        <img v-else :src="previewItem.media_url" :alt="previewItem.title" class="w-100" style="max-height: 70vh; object-fit: contain;">
                    </div>
                    <div v-if="previewItem.description || previewItem.event_date" class="modal-footer flex-column align-items-start border-0">
                        <p v-if="previewItem.description" class="mb-1 text-muted small">{{ previewItem.description }}</p>
                        <small v-if="previewItem.event_date" class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ previewItem.event_date }}</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, defineComponent, h, onMounted, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const loading = ref(true);
const sections = ref([]);
const colleges = ref([]);
const items = ref([]);
const groupedSections = ref([]);
const previewItem = ref(null);
const filters = reactive({ search: '', college_id: '', section_type: '', media_type: '' });
const pagination = reactive({ current_page: 1, last_page: 1, per_page: 12, total: 0 });

const viewMode = computed(() => (filters.section_type ? 'list' : 'grouped'));

const GalleryCard = defineComponent({
    props: { item: { type: Object, required: true } },
    emits: ['open'],
    setup(props, { emit }) {
        return () => h('div', {
            class: 'gallery-card bg-white rounded-3 shadow-sm overflow-hidden h-100',
            onClick: () => emit('open', props.item),
        }, [
            h('div', { class: 'gallery-thumb position-relative' }, [
                props.item.is_video
                    ? h('video', { src: props.item.media_url, class: 'w-100 h-100 object-fit-cover', muted: true })
                    : h('img', { src: props.item.media_url, alt: props.item.title, class: 'w-100 h-100 object-fit-cover' }),
                props.item.is_video
                    ? h('span', { class: 'video-badge' }, [h('i', { class: 'bi bi-play-fill' })])
                    : null,
            ]),
            h('div', { class: 'p-3' }, [
                h('h6', { class: 'fw-bold mb-1 text-truncate' }, props.item.title),
                props.item.college?.name
                    ? h('small', { class: 'text-muted d-block text-truncate' }, props.item.college.name)
                    : null,
                props.item.event_date
                    ? h('small', { class: 'text-muted' }, props.item.event_date)
                    : null,
            ]),
        ]);
    },
});

async function fetchMeta() {
    const [sectionsRes, collegesRes] = await Promise.all([
        axios.get('/college-gallery/sections'),
        axios.get('/college-gallery/colleges'),
    ]);
    sections.value = sectionsRes.data.data.sections;
    colleges.value = collegesRes.data.data.colleges;
}

async function fetchGrouped() {
    loading.value = true;
    try {
        const { data } = await axios.get('/college-gallery/grouped', { params: filters });
        groupedSections.value = data.data.sections;
    } finally {
        loading.value = false;
    }
}

async function fetchList(page = 1) {
    loading.value = true;
    try {
        const { data } = await axios.get('/college-gallery/list', {
            params: { page, ...filters },
        });
        items.value = data.data.items;
        Object.assign(pagination, data.data.pagination);
    } finally {
        loading.value = false;
    }
}

function applyFilters() {
    if (viewMode.value === 'list') {
        fetchList(1);
    } else {
        fetchGrouped();
    }
}

function resetFilters() {
    filters.search = '';
    filters.college_id = '';
    filters.section_type = '';
    filters.media_type = '';
    applyFilters();
}

function openPreview(item) {
    previewItem.value = item;
    document.body.style.overflow = 'hidden';
}

function closePreview() {
    previewItem.value = null;
    document.body.style.overflow = '';
}

onMounted(async () => {
    if (route.query.college_id) {
        filters.college_id = route.query.college_id;
    }
    await fetchMeta();
    await applyFilters();
});
</script>

<style scoped>
.filter-panel {
    position: sticky;
    top: 100px;
}
.section-title {
    color: #1e293b;
    border-left: 4px solid #306c3c;
    padding-left: 12px;
}
.gallery-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.gallery-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1) !important;
}
.gallery-thumb {
    height: 200px;
    background: #e2e8f0;
}
.video-badge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 48px;
    height: 48px;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.5rem;
}
</style>
