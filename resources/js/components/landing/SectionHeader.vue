<template>
    <div class="section-header" :class="{ 'section-header--center': center }">
        <span v-if="eyebrow" class="section-eyebrow">
            <i v-if="icon" :class="icon" class="me-1"></i>
            {{ eyebrow }}
        </span>
        <h2 class="section-title fw-bold">
            <slot name="title">{{ title }}</slot>
        </h2>
        <p v-if="subtitle" class="section-subtitle">{{ subtitle }}</p>
    </div>
</template>

<style scoped lang="scss">
.section-header {
    margin-bottom: 2.5rem;

    &--center {
        text-align: center;

        .section-subtitle {
            margin-left: auto;
            margin-right: auto;
        }
    }
}

.section-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    background: linear-gradient(135deg, rgba(48, 108, 60, 0.1), rgba(34, 197, 94, 0.08));
    border: 1px solid rgba(48, 108, 60, 0.15);
    color: #15803d;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 0.85rem;
}

.section-title {
    font-size: clamp(1.75rem, 3.5vw, 2.5rem);
    line-height: 1.2;
    color: #0f172a;
    margin-bottom: 0.75rem;

    :deep(.accent) {
        background: linear-gradient(90deg, #15803d, #22c55e, #4ade80);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
}

.section-subtitle {
    color: #64748b;
    font-size: 1.05rem;
    max-width: 560px;
    line-height: 1.65;
    margin-bottom: 0;
}
</style>

<script setup>
defineProps({
    eyebrow: { type: String, default: "" },
    title: { type: String, default: "" },
    subtitle: { type: String, default: "" },
    icon: { type: String, default: "" },
    center: { type: Boolean, default: true },
});
</script>
