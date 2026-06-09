<template>
    <section class="my-2">
        <span class="d-block mb-2 mb-lg-3 fs-4 fw-bold">{{ $t('Home') }}/{{ $t('Job Applications') }}</span>

        <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary"></div>
        </div>

        <div v-else-if="applications.length === 0" class="bg-white rounded-3 p-5 text-center theme-shadow">
            <i class="bi bi-briefcase fs-1 text-muted"></i>
            <h5 class="mt-3">{{ $t('No applications yet') }}</h5>
            <p class="text-muted">{{ $t('Browse job openings and apply to track your status here.') }}</p>
            <router-link to="/careers" class="btn btn-primary rounded-pill px-4">{{ $t('View Job Openings') }}</router-link>
        </div>

        <div v-else class="d-flex flex-column gap-3">
            <div v-for="app in applications" :key="app.id" class="bg-white rounded-3 p-4 theme-shadow application-card">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                    <div>
                        <h5 class="fw-bold mb-1">{{ app.job_post?.title }}</h5>
                        <p class="text-muted mb-2">
                            {{ app.job_post?.category?.name }}
                            <span v-if="app.job_post?.company_name"> &bull; {{ app.job_post.company_name }}</span>
                        </p>
                        <small class="text-muted"><i class="bi bi-calendar me-1"></i>{{ $t('Applied on') }}: {{ app.applied_at }}</small>
                    </div>
                    <span class="badge fs-6" :class="statusBadge(app.status)">{{ app.status_label }}</span>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <router-link :to="{ name: 'career_detail', params: { id: app.job_post?.id } }" class="btn btn-outline-primary btn-sm rounded-pill">
                        {{ $t('View Job') }}
                    </router-link>
                    <a v-if="app.resume_url" :href="app.resume_url" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-file-earmark-pdf me-1"></i>{{ $t('My Resume') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const loading = ref(true);
const applications = ref([]);

function statusBadge(status) {
    const map = {
        pending: 'bg-warning text-dark',
        reviewed: 'bg-info text-dark',
        shortlisted: 'bg-primary',
        rejected: 'bg-danger',
        hired: 'bg-success',
    };
    return map[status] || 'bg-secondary';
}

async function fetchApplications() {
    loading.value = true;
    try {
        const { data } = await axios.get('/job/my-applications', {
            headers: { Authorization: `Bearer ${authStore.authToken}` },
        });
        applications.value = data.data.applications;
    } finally {
        loading.value = false;
    }
}

onMounted(fetchApplications);
</script>

<style scoped>
.application-card {
    border-left: 4px solid #306c3c;
    transition: box-shadow 0.2s;
}
.application-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}
</style>
