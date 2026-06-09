<template>
    <section class="py-4" style="background: #F1F5F9; min-height: 70vh;">
        <div class="container">
            <router-link to="/careers" class="btn btn-link text-decoration-none mb-3 ps-0">
                <i class="bi bi-arrow-left me-1"></i>{{ $t('Back to Jobs') }}
            </router-link>

            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary"></div>
            </div>

            <div v-else-if="job" class="row g-4">
                <div class="col-lg-8">
                    <div class="bg-white rounded-3 p-4 shadow-sm">
                        <h2 class="fw-bold">{{ job.title }}</h2>
                        <p class="text-muted">
                            <span v-if="job.company_name">{{ job.company_name }}</span>
                            <span v-if="job.location"> &bull; {{ job.location }}</span>
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-primary">{{ job.category?.name }}</span>
                            <span class="badge bg-light text-dark border">{{ job.job_type_label }}</span>
                            <span v-if="job.salary_range" class="badge bg-success-subtle text-success">{{ job.salary_range }}</span>
                            <span v-if="job.application_deadline" class="badge bg-danger-subtle text-danger">
                                {{ $t('Deadline') }}: {{ job.application_deadline }}
                            </span>
                        </div>

                        <h5 class="fw-bold mt-4">{{ $t('Job Description') }}</h5>
                        <div class="job-rich-content" v-html="job.description"></div>

                        <div v-if="job.requirements">
                            <h5 class="fw-bold mt-4">{{ $t('Requirements') }}</h5>
                            <div class="job-rich-content" v-html="job.requirements"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white rounded-3 p-4 shadow-sm sticky-top" style="top: 100px;">
                        <h5 class="fw-bold mb-3">{{ $t('Apply for this Job') }}</h5>

                        <div v-if="!authStore.authToken" class="text-center py-3">
                            <p class="text-muted">{{ $t('Please login to apply') }}</p>
                            <router-link to="/login" class="btn btn-primary w-100 rounded-pill">{{ $t('Login') }}</router-link>
                        </div>

                        <div v-else-if="hasApplied" class="alert alert-success">
                            <i class="bi bi-check-circle me-1"></i>{{ $t('You have already applied for this job.') }}
                            <router-link to="/dashboard/job-applications" class="d-block mt-2">{{ $t('Track Application Status') }}</router-link>
                        </div>

                        <form v-else @submit.prevent="submitApplication">
                            <div class="mb-3">
                                <label class="form-label">{{ $t('Upload Resume') }} <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" accept=".pdf,.doc,.docx" @change="onResumeChange" required />
                                <small class="text-muted">{{ $t('PDF, DOC, DOCX (max 5MB)') }}</small>
                                <p v-if="errors.resume" class="text-danger small mt-1">{{ errors.resume[0] }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ $t('Cover Letter') }}</label>
                                <textarea v-model="form.cover_letter" class="form-control" rows="4" :placeholder="$t('Tell us why you are a great fit...')"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill" :disabled="submitting">
                                <span v-if="submitting" class="spinner-border spinner-border-sm me-1"></span>
                                {{ $t('Submit Application') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import Swal from 'sweetalert2';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const loading = ref(true);
const submitting = ref(false);
const job = ref(null);
const hasApplied = ref(false);
const errors = ref({});
const form = reactive({ cover_letter: '' });
let resumeFile = null;

function onResumeChange(e) {
    resumeFile = e.target.files[0];
}

async function fetchJob() {
    loading.value = true;
    try {
        const headers = authStore.authToken ? { Authorization: `Bearer ${authStore.authToken}` } : {};
        const { data } = await axios.get(`/job/show/${route.params.id}`, { headers });
        job.value = data.data.job;
        hasApplied.value = data.data.has_applied;
    } catch {
        router.push({ name: 'careers' });
    } finally {
        loading.value = false;
    }
}

async function submitApplication() {
    if (!resumeFile) return;
    submitting.value = true;
    errors.value = {};

    const formData = new FormData();
    formData.append('resume', resumeFile);
    if (form.cover_letter) formData.append('cover_letter', form.cover_letter);

    try {
        await axios.post(`/job/apply/${route.params.id}`, formData, {
            headers: {
                Authorization: `Bearer ${authStore.authToken}`,
                'Content-Type': 'multipart/form-data',
            },
        });
        Swal.fire({ icon: 'success', title: t('Applied!'), text: t('Your application has been submitted.'), timer: 2000, showConfirmButton: false });
        hasApplied.value = true;
    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors || {};
            Swal.fire({ icon: 'error', title: t('Error'), text: e.response.data.message || t('Could not submit application') });
        }
    } finally {
        submitting.value = false;
    }
}

onMounted(fetchJob);
</script>

<style scoped>
.job-rich-content :deep(h1),
.job-rich-content :deep(h2),
.job-rich-content :deep(h3) {
    font-weight: 700;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}
.job-rich-content :deep(p),
.job-rich-content :deep(ul),
.job-rich-content :deep(ol) {
    margin-bottom: 0.75rem;
}
.job-rich-content :deep(ul),
.job-rich-content :deep(ol) {
    padding-left: 1.25rem;
}
</style>
