<template>
    <section class="py-4" style="background: #F1F5F9; min-height: 70vh;">
        <div class="container">
            

            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="bg-white rounded-3 p-3 shadow-sm" style="position: sticky; top: 100px;">
                        <h5 class="fw-bold mb-3">{{ $t('Filters') }}</h5>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('Search') }}</label>
                            <input v-model="filters.search" type="text" class="form-control" :placeholder="$t('Job title, company...')" @keyup.enter="fetchJobs(1)" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('Category') }}</label>
                            <select v-model="filters.category_id" class="form-select" @change="fetchJobs(1)">
                                <option value="">{{ $t('All Categories') }}</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ $t('Job Type') }}</label>
                            <select v-model="filters.job_type" class="form-select" @change="fetchJobs(1)">
                                <option value="">{{ $t('All Types') }}</option>
                                <option value="full_time">{{ $t('Full-Time') }}</option>
                                <option value="internship">{{ $t('Internship') }}</option>
                                <option value="part_time">{{ $t('Part-Time') }}</option>
                                <option value="contract">{{ $t('Contract') }}</option>
                            </select>
                        </div>
                        <button class="btn btn-outline-danger btn-sm w-100" @click="resetFilters">{{ $t('Reset') }}</button>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div v-if="loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>

                    <div v-else-if="jobs.length === 0" class="bg-white rounded-3 p-5 text-center shadow-sm">
                        <i class="bi bi-briefcase fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">{{ $t('No job openings available') }}</h5>
                    </div>

                    <div v-else class="d-flex flex-column gap-3">
                        <div v-for="job in jobs" :key="job.id" class="bg-white rounded-3 p-4 shadow-sm job-card">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ job.title }}</h5>
                                    <p class="text-muted mb-2">
                                        <span v-if="job.company_name">{{ job.company_name }}</span>
                                        <span v-if="job.location"> &bull; {{ job.location }}</span>
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-primary-subtle text-primary">{{ job.category?.name }}</span>
                                        <span class="badge bg-light text-dark">{{ job.job_type_label }}</span>
                                        <span v-if="job.salary_range" class="badge bg-success-subtle text-success">{{ job.salary_range }}</span>
                                    </div>
                                </div>
                                <router-link :to="{ name: 'career_detail', params: { id: job.id } }" class="btn btn-primary btn-sm rounded-pill px-4">
                                    {{ $t('View & Apply') }}
                                </router-link>
                            </div>
                            <p class="text-muted mt-3 mb-0 small">{{ truncate(job.description, 180) }}</p>
                            <small v-if="job.application_deadline" class="text-danger d-block mt-2">
                                <i class="bi bi-clock me-1"></i>{{ $t('Deadline') }}: {{ job.application_deadline }}
                            </small>
                        </div>

                        <nav v-if="pagination.last_page > 1" class="mt-3">
                            <ul class="pagination justify-content-center">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <button class="page-link" @click="fetchJobs(pagination.current_page - 1)">{{ $t('Previous') }}</button>
                                </li>
                                <li v-for="page in pagination.last_page" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                    <button class="page-link" @click="fetchJobs(page)">{{ page }}</button>
                                </li>
                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <button class="page-link" @click="fetchJobs(pagination.current_page + 1)">{{ $t('Next') }}</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';

const loading = ref(true);
const jobs = ref([]);
const categories = ref([]);
const filters = reactive({ search: '', category_id: '', job_type: '' });
const pagination = reactive({ current_page: 1, last_page: 1, per_page: 12, total: 0 });

function stripHtml(html) {
    if (!html) return '';
    const div = document.createElement('div');
    div.innerHTML = html;
    return (div.textContent || div.innerText || '').trim();
}

function truncate(text, len) {
    const plain = stripHtml(text);
    if (!plain) return '';
    return plain.length > len ? plain.substring(0, len) + '...' : plain;
}

async function fetchCategories() {
    const { data } = await axios.get('/job/categories');
    categories.value = data.data.categories;
}

async function fetchJobs(page = 1) {
    loading.value = true;
    try {
        const { data } = await axios.get('/job/list', {
            params: { page, ...filters },
        });
        jobs.value = data.data.jobs;
        Object.assign(pagination, data.data.pagination);
    } finally {
        loading.value = false;
    }
}

function resetFilters() {
    filters.search = '';
    filters.category_id = '';
    filters.job_type = '';
    fetchJobs(1);
}

onMounted(async () => {
    await fetchCategories();
    await fetchJobs();
});
</script>

<style scoped>
.job-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border-left: 4px solid #306c3c;
}
.job-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08) !important;
}
</style>
