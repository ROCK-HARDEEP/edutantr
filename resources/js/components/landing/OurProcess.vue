<template>
    <section class="relative py-16 overflow-hidden bg-gradient-to-b from-primary-50/50 via-slate-50/30 to-white">
        <!-- Background decorations -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-[15%] left-[-8%] w-80 h-80 rounded-full bg-primary-400/20 blur-[80px]"></div>
            <div class="absolute bottom-[10%] right-[-6%] w-80 h-80 rounded-full bg-primary-500/15 blur-[80px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full bg-primary-100/60 border border-primary-200/40 text-primary-700 text-xs font-bold tracking-wider uppercase mb-4">
                    <i class="bi bi-signpost-split-fill"></i>
                    {{ $t('How It Works') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-navy mb-3 leading-tight">
                    {{ $t('Our') }}
                    <span class="gradient-text">{{ $t('Process') }}</span>
                </h2>
                <p class="text-slate text-base md:text-lg max-w-xl mx-auto">
                    {{ $t('A simple step-by-step journey from enrollment to career success.') }}
                </p>
            </div>

            <!-- Timeline Track -->
            <div class="relative">
                <!-- Desktop Track Line -->
                <div class="hidden lg:block absolute top-[42px] left-[8%] right-[8%] h-[3px] rounded-full bg-gradient-to-r from-primary-200 via-primary-500 to-primary-200 overflow-hidden z-0">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/60 to-transparent bg-[length:200%_100%] animate-[shimmer_3.2s_linear_infinite]"></div>
                    <div class="absolute top-1/2 -mt-[7px] w-3.5 h-3.5 rounded-full bg-gradient-to-b from-white via-primary-400 to-primary-700 shadow-[0_0_14px_rgba(34,197,94,0.75)] animate-[runner_3s_linear_infinite]"></div>
                </div>

                <!-- Steps Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-4 relative z-1">
                    <div
                        v-for="(step, index) in steps"
                        :key="step.title"
                        class="flex flex-col items-center text-center"
                        :style="{ animationDelay: `${index * 0.14}s` }"
                    >
                        <!-- Number + Node -->
                        <div class="flex flex-col items-center gap-2 mb-4">
                            <span class="text-[0.68rem] font-extrabold tracking-wider text-primary-700 bg-primary-50 px-2.5 py-1 rounded-full border border-primary-200/40">
                                {{ String(index + 1).padStart(2, '0') }}
                            </span>
                            <div class="relative flex items-center justify-center">
                                <span class="absolute w-[52px] h-[52px] rounded-full border-2 border-primary-400/30"></span>
                                <span class="relative z-10 w-[52px] h-[52px] rounded-full bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center text-lg border-[3px] border-white shadow-lg shadow-primary-700/28 transition-transform duration-300 hover:scale-110">
                                    <i :class="step.icon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Card -->
                        <div class="w-full bg-white rounded-2xl border border-primary-100/14 shadow-md hover:-translate-y-1 hover:shadow-lg hover:border-primary-200/30 transition-all duration-300 p-5">
                            <span class="inline-block text-[0.65rem] font-bold text-primary-700 tracking-wider uppercase px-2.5 py-1 rounded-full bg-gradient-to-br from-primary-50 to-primary-100/60 border border-primary-200/15 mb-2">
                                {{ step.label }}
                            </span>
                            <h3 class="text-base font-bold text-navy mb-2 leading-snug">
                                {{ step.title }}
                            </h3>
                            <p class="text-slate text-[0.9rem] leading-relaxed">
                                {{ step.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const titleWords = ["Process", "Journey", "Method", "Approach"];

const steps = [
    {
        label: "Step 1",
        title: "Choose Your Tech Track",
        description: "Pick from Full-Stack, Data Science, Cloud, or DevOps — structured programs designed for real jobs.",
        icon: "bi bi-compass-fill",
    },
    {
        label: "Step 2",
        title: "Learn Through Live Projects",
        description: "Build real applications with industry mentors. No recorded videos — hands-on, live training.",
        icon: "bi bi-code-slash",
    },
    {
        label: "Step 3",
        title: "Build Your Portfolio",
        description: "Create a GitHub profile and project showcase that impresses hiring managers.",
        icon: "bi bi-kanban-fill",
    },
    {
        label: "Step 4",
        title: "Get Placed",
        description: "Interview prep, mock interviews, and dedicated placement assistance to land your dream job.",
        icon: "bi bi-rocket-takeoff-fill",
    },
];
</script>

<style scoped>
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.15); opacity: 0; }
}
@keyframes runner {
    0% { left: 0; opacity: 0.4; }
    8% { opacity: 1; }
    92% { opacity: 1; }
    100% { left: calc(100% - 14px); opacity: 0.4; }
}
@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(24px, -18px) scale(1.08); }
}
</style>
