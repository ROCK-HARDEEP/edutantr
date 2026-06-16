<template>
    <div class="text-center mb-10" :class="{ 'text-center': center }">
        <span v-if="eyebrow" class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full bg-primary-100/60 border border-primary-200/40 text-primary-700 text-xs font-bold tracking-wider uppercase mb-3">
            <i v-if="icon" :class="icon" class="mr-1"></i>
            {{ eyebrow }}
        </span>
        <h2 class="text-3xl md:text-4xl font-bold text-navy leading-tight mb-2">
            <slot name="title">{{ title }}</slot>
        </h2>
        <p v-if="subtitle" class="text-slate text-base md:text-lg max-w-xl mx-auto leading-relaxed">
            {{ subtitle }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    eyebrow: { type: String, default: "" },
    title: { type: String, default: "" },
    subtitle: { type: String, default: "" },
    icon: { type: String, default: "" },
    center: { type: Boolean, default: true },
});
</script>
