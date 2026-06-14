<template>
    <div v-if="hasProjectContent" class="p-4 bg-white rounded-3">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-kanban fs-4 text-primary"></i>
            <h5 class="fw-bold mb-0">{{ project.title || $t('Course Project') }}</h5>
        </div>

        <article v-if="hasDescription" class="project-description mb-4" v-html="project.description"></article>

        <div v-if="project.pdf_url" class="border rounded-3 p-3 bg-light">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <p class="mb-1 fw-semibold">{{ $t('Project Guide PDF') }}</p>
                    <small class="text-muted">{{ project.pdf_name || $t('Download the detailed project document') }}</small>
                </div>
                <a :href="project.pdf_url" target="_blank" class="btn btn-primary btn-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    {{ $t('Download PDF') }}
                </a>
            </div>
        </div>
    </div>

    <div v-else class="text-center text-muted py-5">
        <i class="bi bi-kanban display-5"></i>
        <p class="mb-0 mt-3">{{ $t('No project details available for this course yet.') }}</p>
    </div>
</template>

<style scoped lang="scss">
.project-description :deep(img) {
    max-width: 100%;
    height: auto;
}

.project-description :deep(p:last-child) {
    margin-bottom: 0;
}
</style>

<script setup>
import { computed } from "vue";

const props = defineProps({
    project: {
        type: Object,
        default: null,
    },
});

const hasDescription = computed(() => {
    const plainText = props.project?.description?.replace(/<[^>]*>/g, "").trim() ?? "";
    return plainText.length > 0;
});

const hasProjectContent = computed(() => {
    if (!props.project) {
        return false;
    }

    return Boolean(props.project.title || hasDescription.value || props.project.pdf_url);
});
</script>
