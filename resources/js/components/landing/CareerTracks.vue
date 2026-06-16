<template>
    <section class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <SectionHeader
                :eyebrow="$t('Featured Courses')"
                icon="bi bi-diagram-3-fill"
                :subtitle="$t('Structured programs designed to take you from beginner to job-ready in months.')"
            >
                <template #title>
                    {{ $t('Our') }}
                    <span class="gradient-text">{{ $t('Courses') }}</span>
                </template>
            </SectionHeader>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div
                    v-for="(track, index) in careerTracks"
                    :key="track.title"
                    class="group relative overflow-hidden rounded-2xl p-6 md:p-8 cursor-pointer card-hover border border-slate-100"
                    :class="track.bgClass"
                    :style="{ animationDelay: `${index * 0.1}s` }"
                >
                    <!-- Background decoration -->
                    <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-20 blur-3xl pointer-events-none"
                         :class="track.glowClass"></div>

                    <!-- Icon -->
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl mb-4 shadow-lg"
                         :class="track.iconBgClass">
                        <i :class="track.icon"></i>
                    </div>

                    <!-- Content -->
                    <h3 class="text-xl font-bold text-navy mb-2 group-hover:text-primary-700 transition-colors">
                        {{ track.title }}
                    </h3>
                    <p class="text-slate text-sm mb-4 leading-relaxed">
                        {{ track.description }}
                    </p>

                    <!-- Meta -->
                    <div class="flex flex-wrap items-center gap-4 mb-4 text-sm">
                        <span class="inline-flex items-center gap-1.5 text-slate font-medium">
                            <i class="bi bi-clock text-primary-500"></i>
                            {{ track.duration }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-slate font-medium">
                            <i class="bi bi-journal-bookmark text-primary-500"></i>
                            {{ track.courses }} {{ $t('Courses') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-slate font-medium">
                            <i class="bi bi-currency-rupee text-primary-500"></i>
                            {{ track.salary }}
                        </span>
                    </div>

                    <!-- Tech Stack -->
                    <div class="flex flex-wrap gap-2 mb-5">
                        <span
                            v-for="tech in track.techStack"
                            :key="tech"
                            class="px-2.5 py-1 rounded-lg bg-white/60 text-xs font-semibold border border-white/40"
                            :class="track.techClass"
                        >
                            {{ tech }}
                        </span>
                    </div>

                    <!-- CTA -->
                    <router-link
                        :to="track.link"
                        class="inline-flex items-center gap-2 font-bold text-sm transition-all duration-200 group-hover:gap-3"
                        :class="track.linkClass"
                    >
                        {{ $t('View Program') }}
                        <i class="bi bi-arrow-right text-sm"></i>
                    </router-link>
                </div>
            </div>
            <div class="text-center mt-10">
                <router-link
                    to="/programs"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:gap-3"
                >
                    {{ $t('View All Courses') }}
                    <i class="bi bi-arrow-right"></i>
                </router-link>
            </div>
        </div>
    </section>
</template>

<script setup>
import SectionHeader from "./SectionHeader.vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const careerTracks = [
    {
        title: "Full Stack Web Development",
        description: "Master React, Node.js, databases, and deployment. Build complete web applications from scratch.",
        duration: "6 Months",
        courses: 8,
        salary: "₹4-12 LPA",
        techStack: ["React", "Node.js", "MongoDB", "AWS"],
        icon: "bi bi-code-slash",
        link: "/programs/full-stack-web-development",
        bgClass: "bg-gradient-to-br from-blue-50 to-indigo-50/50",
        glowClass: "bg-blue-400",
        iconBgClass: "bg-gradient-to-br from-blue-500 to-indigo-600",
        techClass: "text-blue-700",
        linkClass: "text-blue-600 hover:text-blue-700",
    },
    {
        title: "Artificial Intelligence with Machine Learning",
        description: "Build intelligent systems using Python, TensorFlow, and deep learning algorithms.",
        duration: "6 Months",
        courses: 7,
        salary: "₹5-15 LPA",
        techStack: ["Python", "TensorFlow", "PyTorch", "Scikit-learn"],
        icon: "bi bi-robot",
        link: "/programs/ai-machine-learning",
        bgClass: "bg-gradient-to-br from-purple-50 to-violet-50/50",
        glowClass: "bg-purple-400",
        iconBgClass: "bg-gradient-to-br from-purple-500 to-violet-600",
        techClass: "text-purple-700",
        linkClass: "text-purple-600 hover:text-purple-700",
    },
    {
        title: "Data Science",
        description: "Analyze data, build models, and create visualizations that drive business decisions.",
        duration: "5 Months",
        courses: 6,
        salary: "₹4-12 LPA",
        techStack: ["Python", "SQL", "Power BI", "Excel"],
        icon: "bi bi-graph-up-arrow",
        link: "/programs/data-science",
        bgClass: "bg-gradient-to-br from-emerald-50 to-teal-50/50",
        glowClass: "bg-emerald-400",
        iconBgClass: "bg-gradient-to-br from-emerald-500 to-teal-600",
        techClass: "text-emerald-700",
        linkClass: "text-emerald-600 hover:text-emerald-700",
    },
];
</script>
