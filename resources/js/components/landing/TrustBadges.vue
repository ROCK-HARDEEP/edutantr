<template>
    <section class="py-10 md:py-14 bg-gradient-to-r from-slate-50 via-white to-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
                <div
                    v-for="badge in badges"
                    :key="badge.label"
                    class="group flex flex-col items-center justify-center gap-2 p-4 rounded-xl bg-white border border-slate-200 shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-md hover:border-primary-200 cursor-default grayscale hover:grayscale-0"
                >
                    <i :class="badge.icon" class="text-2xl md:text-3xl text-slate-400 group-hover:text-primary-500 transition-colors duration-300"></i>
                    <span class="text-xs md:text-sm font-semibold text-slate-500 group-hover:text-slate-800 transition-colors duration-300 text-center leading-tight">
                        {{ badge.label }}
                    </span>
                    <span v-if="badge.sub" class="text-[10px] md:text-xs text-slate-400 group-hover:text-slate-600 transition-colors duration-300">
                        {{ badge.sub }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const badges = [
    { icon: 'bi bi-star-fill', label: 'Google Reviews', sub: '4.8 / 5 ★' },
    { icon: 'bi bi-phone', label: 'App Store', sub: '4.5 ★' },
    { icon: 'bi bi-patch-check-fill', label: 'ISO Certified', sub: null },
    { icon: 'bi bi-award-fill', label: 'NSDC Affiliated', sub: null },
    { icon: 'bi bi-people-fill', label: '10,000+', sub: 'Learners' },
    { icon: 'bi bi-building', label: '500+', sub: 'Companies' },
];
</script>
