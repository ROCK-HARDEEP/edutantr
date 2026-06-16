<template>
    <div class="min-h-screen bg-slate-50">
        <!-- Hero Section -->
        <section class="relative pt-32 pb-24 bg-slate-900 overflow-hidden">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(circle at 80% 0%, rgba(20,184,166,0.15) 0%, transparent 70%);"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-400 text-sm font-semibold tracking-wide mb-6">
                    <i class="bi bi-briefcase-fill"></i> {{ $t("Join Our Network") }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight" style="font-family: 'Lexend', sans-serif;">
                    {{ $t('Career Support &') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-500">{{ $t('Opportunities') }}</span>
                </h1>
                <p class="text-lg text-slate-300 max-w-3xl mx-auto font-light leading-relaxed mb-10">
                    {{ $t('Edutantr was founded with a bold vision: to bridge the gap between ambitious talent and industry demands. We don\'t just train you; we launch you. Experience unparalleled career support designed to get you hired.') }}
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <router-link to="/programs" class="px-8 py-4 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(20,184,166,0.3)] hover:-translate-y-0.5 hover:shadow-[0_0_30px_rgba(20,184,166,0.5)] transition-all duration-300">
                        {{ $t('Explore Courses') }}
                    </router-link>
                    <a href="#placement-process" class="px-8 py-4 bg-white/10 text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 backdrop-blur-sm border border-white/10">
                        {{ $t('View Placement Process') }}
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats / Highlights Row -->
        <section class="relative z-20 -mt-12 mb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="flex gap-6 items-start group">
                            <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-sm border border-amber-100">
                                <i class="bi bi-map-fill text-amber-500 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-900 mb-2">{{ $t('Strategic Career Planning') }}</h4>
                                <p class="text-slate-600 leading-relaxed">{{ $t('We provide personalized roadmaps, continuous portfolio reviews, and targeted skill development to ensure you are job-ready for top-tier companies from day one.') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-6 items-start group">
                            <div class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-sm border border-teal-100">
                                <i class="bi bi-graph-up-arrow text-teal-600 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-900 mb-2">{{ $t('Rapid Growth Opportunities') }}</h4>
                                <p class="text-slate-600 leading-relaxed">{{ $t('Joining our network means exclusive access to fast-tracked career paths, hidden job markets, and direct referrals to our rapidly growing network of tech partners.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Career Path Section (Placement Process) -->
        <section id="placement-process" class="py-16 md:py-24 bg-white border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4" style="font-family: 'Lexend', sans-serif;">{{ $t('How We Guarantee Your Success') }}</h2>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto">{{ $t('Our career support isn’t an afterthought—it is built into every step of your educational journey.') }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    <!-- Connecting line for desktop -->
                    <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gradient-to-r from-slate-100 via-teal-200 to-slate-100 -translate-y-1/2 z-0"></div>

                    <!-- Step 1 -->
                    <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 shadow-lg hover:-translate-y-2 transition-all duration-300 relative z-10 group">
                        <div class="absolute -top-6 left-8 w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 text-white font-bold flex items-center justify-center text-xl shadow-xl shadow-slate-900/20 group-hover:scale-110 transition-transform">1</div>
                        <h3 class="text-2xl font-bold text-slate-900 mt-6 mb-4">{{ $t('Skill Mastery') }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $t('Before talking to recruiters, we ensure you have undeniable skills. You will build complex, real-world projects that prove your capabilities to any hiring manager.') }}</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 shadow-lg hover:-translate-y-2 transition-all duration-300 relative z-10 group">
                        <div class="absolute -top-6 left-8 w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white font-bold flex items-center justify-center text-xl shadow-xl shadow-teal-500/30 group-hover:scale-110 transition-transform">2</div>
                        <h3 class="text-2xl font-bold text-slate-900 mt-6 mb-4">{{ $t('Interview Prep') }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $t('Participate in rigorous mock interviews with industry veterans. We refine your communication, technical answers, algorithm problem-solving, and salary negotiation tactics.') }}</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 shadow-lg hover:-translate-y-2 transition-all duration-300 relative z-10 group">
                        <div class="absolute -top-6 left-8 w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 text-white font-bold flex items-center justify-center text-xl shadow-xl shadow-orange-500/30 group-hover:scale-110 transition-transform">3</div>
                        <h3 class="text-2xl font-bold text-slate-900 mt-6 mb-4">{{ $t('Placement & Growth') }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $t('We don’t stop until you are hired. Even after your first placement, we remain your career partner, helping you navigate promotions, job changes, and leadership opportunities.') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mentorship & Industry Connect -->
        <section class="py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-16 text-white relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-teal-500 rounded-full blur-[120px] opacity-20 pointer-events-none translate-x-1/3 -translate-y-1/3"></div>
                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-teal-300 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-md">
                                <i class="bi bi-link-45deg"></i> {{ $t('Network Effect') }}
                            </span>
                            <h2 class="text-3xl md:text-5xl font-bold mb-6 leading-tight" style="font-family: 'Lexend', sans-serif;">{{ $t('Direct Industry Connections') }}</h2>
                            <p class="text-lg text-slate-300 mb-8 font-light leading-relaxed">
                                {{ $t('Your resume won’t get lost in a pile. Because we work directly with hiring managers and startup founders, our students get priority interviews. Our network becomes your network.') }}
                            </p>
                            <ul class="space-y-5">
                                <li class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                                    <div class="w-10 h-10 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <span class="font-medium">{{ $t('Exclusive Hiring Drives & Job Fairs') }}</span>
                                </li>
                                <li class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                                    <div class="w-10 h-10 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <span class="font-medium">{{ $t('1-on-1 Mentorship from Tech Leads') }}</span>
                                </li>
                                <li class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                                    <div class="w-10 h-10 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <span class="font-medium">{{ $t('Resume & LinkedIn Profile Optimization') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="flex justify-center lg:justify-end">
                            <div class="relative w-full max-w-sm">
                                <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-emerald-400 rounded-3xl blur-2xl opacity-30 animate-pulse"></div>
                                <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl relative z-10 text-center">
                                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-teal-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-3xl shadow-xl mb-6">
                                        <i class="bi bi-rocket-takeoff-fill"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white mb-2">{{ $t('Ready to Launch?') }}</h3>
                                    <p class="text-slate-300 mb-8 text-sm">{{ $t('Join thousands of successful graduates who started right here.') }}</p>
                                    <router-link to="/programs" class="block w-full py-4 bg-white text-slate-900 hover:bg-slate-100 font-bold rounded-xl transition-colors shadow-lg">
                                        {{ $t('View Programs') }}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
</script>

<style scoped>
</style>
