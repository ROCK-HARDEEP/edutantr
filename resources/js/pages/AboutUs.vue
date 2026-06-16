<template>
    <div>
    <!-- Hero / Why Choose Section -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-slate-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                <!-- Image -->
                <div class="animate-slide-left">
                    <img
                        class="w-full rounded-2xl shadow-xl"
                        loading="lazy"
                        src="/public/assets/website/teacher.jpg"
                        alt="About Edutantr"
                    />
                </div>

                <!-- Content -->
                <div class="animate-slide-right">
                    <h2 class="text-3xl md:text-4xl font-bold text-navy mb-4">
                        {{ $t('Why Choose') }}
                        <span class="text-primary-600">Edutandr</span>?
                    </h2>
                    <p class="text-lg text-slate mb-4 leading-relaxed">
                        {{ $t('We help people to build incredible brands and superior products. Our perspective is to furnish outstanding captivating services') }}.
                    </p>
                    <p class="text-slate mb-8 leading-relaxed">
                        {{ $t('We are a fast-growing company, but we have never lost sight of our core values. We believe in collaboration, innovation, and customer satisfaction. We are always looking for new ways to improve our products and services') }}.
                    </p>

                    <!-- Feature Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-100 card-hover">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                                <i class="pi pi-cog text-primary-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-navy mb-1">{{ $t('Trusted Company') }}</h3>
                                <p class="text-sm text-slate leading-relaxed">
                                    {{ $t('We are crafting a digital method that subsists life across all mediums') }}.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-100 card-hover">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center">
                                <i class="pi pi-bolt text-amber-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-navy mb-1">{{ $t('eLearning Platform') }}</h3>
                                <p class="text-sm text-slate leading-relaxed">
                                    {{ $t('We believe in innovation by merging primary with elaborate ideas') }}.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story & Mission Section -->
    <section class="py-16 md:py-24 relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <!-- Floating decorative elements -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-primary-500 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
        <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-500 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[url('/public/assets/website/pattern.png')] opacity-5 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-primary-300 text-sm font-bold tracking-widest uppercase mb-4 backdrop-blur-sm border border-white/10 shadow-sm">
                    {{ $t('Our Story') }}
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                    {{ $t('A Fresh Start with a Bold Vision') }}
                </h2>
                <p class="text-lg text-slate-300 leading-relaxed font-light">
                    {{ $t('Edutantr launched just a few weeks ago, but our mission has been years in the making. We recognized a massive gap between traditional education and actual industry needs. We decided to do our absolute best to close it by creating a platform that prioritizes real-world skills, practical execution, and direct career placement.') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group bg-white/5 backdrop-blur-lg rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-rose-400 to-rose-600 rounded-2xl flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(225,29,72,0.3)] group-hover:scale-110 transition-transform">
                        <i class="pi pi-heart-fill text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $t('How We Do Our Best') }}</h3>
                    <p class="text-slate-300 text-sm leading-relaxed font-light">
                        {{ $t('We pour our energy into curating industry-relevant curriculum. Our team works tirelessly day and night to partner with top-tier mentors and ensure that every piece of content we produce directly translates to employable skills.') }}
                    </p>
                </div>
                
                <!-- Card 2 -->
                <div class="group bg-white/5 backdrop-blur-lg rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(245,158,11,0.3)] group-hover:scale-110 transition-transform">
                        <i class="pi pi-star-fill text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $t('Creating Opportunities') }}</h3>
                    <p class="text-slate-300 text-sm leading-relaxed font-light">
                        {{ $t('We don’t just teach; we connect. By networking with leading tech companies and startups, Edutantr creates exclusive internship and full-time placement opportunities tailored specifically for our graduates.') }}
                    </p>
                </div>
                
                <!-- Card 3 -->
                <div class="group bg-white/5 backdrop-blur-lg rounded-3xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(59,130,246,0.3)] group-hover:scale-110 transition-transform">
                        <i class="pi pi-rocket text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $t('Future Focused') }}</h3>
                    <p class="text-slate-300 text-sm leading-relaxed font-light">
                        {{ $t('Although we are young, our trajectory is clear. We are building an ecosystem where students, professionals, and companies thrive together. Your growth is the metric by which we measure our own success.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Success Section -->
    <section class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Content -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-navy mb-4">{{ $t('Our Success') }}</h2>
                    <p class="text-lg text-slate mb-6 leading-relaxed">
                        {{ $t('With years of experience and deep industry knowledge, we have a proven track record of success and are constantly pushing ourselves to stay ahead of the curve') }}.
                    </p>

                    <!-- Highlight Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                            <i class="pi pi-bolt text-primary-600 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-navy">
                                {{ $t('Our evolution procedure is super intelligent') }}.
                            </p>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                            <i class="pi pi-star text-amber-500 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-navy">
                                {{ $t('We deliver services beyond expectations') }}.
                            </p>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                            <i class="pi pi-users text-primary-500 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-navy">
                                {{ $t("Let's hire us to reach your objectives") }}.
                            </p>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                            <i class="pi pi-chart-bar text-red-500 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-navy">
                                {{ $t('Proven track record of business growth') }}.
                            </p>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <div class="mt-6">
                        <router-link
                            to="/contact-us"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-semibold rounded-full shadow-lg hover:bg-primary-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5"
                        >
                            <i class="pi pi-comments"></i>
                            {{ $t('Connect Now') }}
                        </router-link>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="text-center animate-slide-right">
                    <img
                        class="w-full rounded-2xl shadow-xl"
                        loading="lazy"
                        src="/public/assets/website/about2.jpg"
                        alt="Our Success"
                    />
                </div>
            </div>
        </div>
    </section>



    <!-- Google Map Section -->
    <section
        v-if="masterStore.masterData?.google_map && masterStore.masterData?.google_map != ''"
        class="py-16 md:py-24 bg-slate-50"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-navy text-center mb-10">
                {{ $t('Find Us on Google Maps') }}
            </h2>
            <div class="max-w-5xl mx-auto">
                <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-xl border border-slate-200">
                    <div v-html="masterStore.masterData?.google_map" class="w-full h-full"></div>
                </div>
            </div>
        </div>
    </section>
    </div>
</template>

<script setup>
import { useMasterStore } from "@/stores/master";
const masterStore = useMasterStore();
</script>
