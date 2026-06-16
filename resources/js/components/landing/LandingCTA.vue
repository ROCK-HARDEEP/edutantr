<template>
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl p-8 md:p-12" style="background: linear-gradient(135deg, #052e16 0%, #14532d 40%, #166534 70%, #15803d 100%); border: 1px solid rgba(134,239,172,0.2); box-shadow: 0 20px 50px rgba(5,46,22,0.3);">
                <!-- Background Pattern -->
                <div class="absolute inset-0 pointer-events-none overflow-hidden">
                    <i class="bi bi-mortarboard absolute text-[4rem] md:text-[6rem] text-white/[0.04] top-[10%] right-[8%] rotate-12"></i>
                    <i class="bi bi-rocket-takeoff absolute text-[4rem] md:text-[6rem] text-white/[0.04] bottom-[10%] left-[5%] -rotate-8"></i>
                    <i class="bi bi-lightbulb absolute text-[4rem] md:text-[6rem] text-amber-400/[0.08] top-[40%] left-[40%] rotate-6"></i>
                </div>

                <!-- Glow -->
                <div class="absolute -top-1/2 -right-[10%] w-[400px] h-[400px] rounded-full bg-emerald-400/25 blur-[60px] pointer-events-none"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                    <!-- Text -->
                    <div class="flex-1 text-center lg:text-left">
                        <h3 class="text-white font-bold text-xl md:text-2xl lg:text-[1.85rem] leading-snug mb-3">
                            {{ $t('Ready to Start Your IT Career?') }}
                        </h3>
                        <p class="text-white/75 text-base max-w-lg mx-auto lg:mx-0">
                            {{ $t('Join thousands of students already working at top tech companies') }}
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-end gap-3">
                        <router-link
                            to="/programs"
                            class="inline-flex items-center gap-2 px-7 py-3 rounded-full text-base font-bold transition-all duration-250 shadow-lg hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #1c1917; box-shadow: 0 8px 24px rgba(251,191,36,0.35);"
                        >
                            {{ $t('Enroll Now') }}
                            <i class="bi bi-arrow-right"></i>
                        </router-link>
                        <router-link
                            to="/contact-us"
                            class="inline-flex items-center gap-2 px-7 py-3 rounded-full text-base font-bold text-white border-2 border-white/45 bg-white/10 backdrop-blur-md hover:bg-white/18 hover:border-white transition-all duration-250"
                        >
                            {{ $t('Talk to a Counselor') }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
</script>
