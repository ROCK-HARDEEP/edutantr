<template>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <SectionHeader
                :eyebrow="$t('Our Mentors')"
                icon="bi bi-people-fill"
                :subtitle="$t('Learn from industry experts who have shaped careers at top tech companies.')"
            >
                <template #title>
                    {{ $t('Meet Your') }}
                    <span class="gradient-text">{{ $t('Instructors') }}</span>
                </template>
            </SectionHeader>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="(mentor, index) in mentors"
                    :key="mentor.id"
                    class="group bg-white rounded-2xl border border-slate-100 p-6 text-center shadow-sm hover:-translate-y-2 hover:shadow-xl hover:border-primary-200/30 transition-all duration-300"
                >
                    <!-- Avatar with initials (no image) -->
                    <div class="w-20 h-20 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg"
                         :class="mentor.colorClass">
                        {{ mentor.initials }}
                    </div>

                    <h4 class="font-bold text-navy text-base mb-1 group-hover:text-primary-700 transition-colors">
                        {{ mentor.name }}
                    </h4>

                    <p class="text-primary-600 text-sm font-semibold mb-1">
                        {{ mentor.specialization }}
                    </p>

                    <p class="text-slate text-xs mb-3">
                        {{ mentor.experience }}
                    </p>

                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                          :class="mentor.badgeClass">
                        {{ mentor.badge }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import SectionHeader from "./SectionHeader.vue";

const mentors = [
    {
        id: 1,
        name: "Rajesh Kumar",
        initials: "RK",
        specialization: "Full-Stack Development",
        experience: "12 years at TCS",
        badge: "React & Node.js",
        colorClass: "bg-gradient-to-br from-blue-500 to-blue-700",
        badgeClass: "bg-blue-50 text-blue-700",
    },
    {
        id: 2,
        name: "Priya Venkatesh",
        initials: "PV",
        specialization: "Data Science & AI",
        experience: "8 years at Infosys",
        badge: "Python & ML",
        colorClass: "bg-gradient-to-br from-emerald-500 to-emerald-700",
        badgeClass: "bg-emerald-50 text-emerald-700",
    },
    {
        id: 3,
        name: "Arun Prasad",
        initials: "AP",
        specialization: "Cloud Computing (AWS)",
        experience: "10 years at Wipro",
        badge: "AWS & DevOps",
        colorClass: "bg-gradient-to-br from-orange-500 to-orange-700",
        badgeClass: "bg-orange-50 text-orange-700",
    },
    {
        id: 4,
        name: "Deepa Lakshmi",
        initials: "DL",
        specialization: "UI/UX Design",
        experience: "7 years at HCL",
        badge: "Figma & Design",
        colorClass: "bg-gradient-to-br from-purple-500 to-purple-700",
        badgeClass: "bg-purple-50 text-purple-700",
    },
];
</script>
