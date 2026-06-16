<template>
    <section class="bg-slate-50 py-0">
        <PartnerCollegesSection />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <!-- Our Placement Promise Section -->
            <div class="placement-promise-section">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <span class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full bg-primary-100/60 border border-primary-200/40 text-primary-700 text-xs font-bold tracking-wider uppercase mb-4">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                        {{ $t('Our Placement Promise') }}
                    </span>
                    <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mt-3 mb-3">
                        {{ $t("We don't just train — we transform careers.") }}
                    </h3>
                    <p class="text-slate-600 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                        {{ $t("Here's how we ensure every student gets placed.") }}
                    </p>
                </div>

                <!-- 4 Promise Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">
                    <!-- Card 1: Industry-Ready Curriculum -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center hover:-translate-y-1.5 hover:shadow-xl hover:border-primary-200/40 transition-all duration-300 group">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-primary-50 border border-primary-200/30 flex items-center justify-center group-hover:bg-primary-100 transition-colors duration-300">
                            <i class="bi bi-easel-fill text-primary-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Industry-Ready Curriculum</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Courses designed with input from 50+ hiring managers to match real job requirements</p>
                    </div>

                    <!-- Card 2: Mock Interview Program -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center hover:-translate-y-1.5 hover:shadow-xl hover:border-primary-200/40 transition-all duration-300 group">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-primary-50 border border-primary-200/30 flex items-center justify-center group-hover:bg-primary-100 transition-colors duration-300">
                            <i class="bi bi-person-video3 text-primary-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Mock Interview Program</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Practice with former HR heads from top IT companies before your actual interview</p>
                    </div>

                    <!-- Card 3: Resume & Portfolio Building -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center hover:-translate-y-1.5 hover:shadow-xl hover:border-primary-200/40 transition-all duration-300 group">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-primary-50 border border-primary-200/30 flex items-center justify-center group-hover:bg-primary-100 transition-colors duration-300">
                            <i class="bi bi-file-earmark-person-fill text-primary-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Resume &amp; Portfolio Building</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Professional resume review and GitHub portfolio optimization by career experts</p>
                    </div>

                    <!-- Card 4: Dedicated Placement Cell -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center hover:-translate-y-1.5 hover:shadow-xl hover:border-primary-200/40 transition-all duration-300 group">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-primary-50 border border-primary-200/30 flex items-center justify-center group-hover:bg-primary-100 transition-colors duration-300">
                            <i class="bi bi-briefcase-fill text-primary-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Dedicated Placement Cell</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Our placement team works with 200+ partner companies to match you with the right opportunity</p>
                    </div>
                </div>

                <!-- Stat Bar -->
                <div class="bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700 rounded-2xl p-6 md:p-8 shadow-lg">
                    <div class="text-center mb-6">
                        <h4 class="text-lg md:text-xl font-bold text-white tracking-wide uppercase">
                            {{ $t('Our Track Record') }}
                        </h4>
                        <p class="text-primary-200 text-sm mt-1">Built on a foundation of student-first commitment</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Stat 1 -->
                        <div class="text-center px-4">
                            <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">200+</div>
                            <div class="text-primary-200 text-sm font-semibold tracking-wide">Partner Companies</div>
                        </div>
                        <!-- Stat 2 -->
                        <div class="text-center px-4 sm:border-x sm:border-primary-500/30">
                            <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">95%</div>
                            <div class="text-primary-200 text-sm font-semibold tracking-wide">Interview Success Rate</div>
                        </div>
                        <!-- Stat 3 -->
                        <div class="text-center px-4">
                            <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">100%</div>
                            <div class="text-primary-200 text-sm font-semibold tracking-wide">Placement Assistance</div>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center mt-10">
                    <router-link
                        to="/programs"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-primary-600 text-white font-bold text-base hover:bg-primary-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300"
                    >
                        <i class="bi bi-rocket-takeoff-fill"></i>
                        {{ $t('Start Your Career Journey') }}
                    </router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import PartnerCollegesSection from "./PartnerCollegesSection.vue";
</script>
