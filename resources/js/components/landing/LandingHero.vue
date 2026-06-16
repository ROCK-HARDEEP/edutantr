<template>
    <section class="relative min-h-[100svh] overflow-hidden bg-[#0a0a0a]">
        <!-- Partner Logos Background -->
        <div v-if="hasPartnerBg" class="absolute inset-0 overflow-hidden z-0" aria-hidden="true">
            <div class="flex h-full w-max" style="animation: hero-marquee 30s linear infinite; will-change: transform;">
                <div v-for="stripIndex in 2" :key="`strip-${stripIndex}`" class="flex w-screen h-full shrink-0">
                    <div v-for="(item, index) in heroCompanyPartners"
                         :key="`partner-${stripIndex}-${item.id ?? index}`"
                         class="flex-1 h-full overflow-hidden border-r border-white/5 last:border-r-0">
                        <img :src="item.logo" :alt="item.name" class="w-full h-full object-cover grayscale-[10%] contrast-[1.05]" loading="lazy" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark Overlay -->
        <div class="absolute inset-0 z-1 pointer-events-none"
             style="background: radial-gradient(ellipse 70% 60% at 50% 45%, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.72) 100%), linear-gradient(180deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.65) 50%, rgba(0,0,0,0.8) 100%);"></div>

        <!-- Dot Grid Pattern -->
        <div class="absolute inset-0 z-1 pointer-events-none" aria-hidden="true"
             style="background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 28px 28px;"></div>

        <!-- Hero Content -->
        <div class="relative z-2 w-full max-w-[1200px] mx-auto min-h-[calc(100svh-120px)] flex flex-col items-center justify-center px-6 pt-28 pb-16">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Left: Text -->
                <div class="text-center md:text-left flex flex-col items-center md:items-start relative z-10">
                    <div class="hero-stagger-1 inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-md shadow-lg shadow-black/20 text-white/90 text-sm font-semibold tracking-wide mb-8 hover:bg-white/10 transition-colors cursor-default">
                        <div class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-pulse-dot shadow-[0_0_10px_rgba(249,115,22,0.8)]"></div>
                        {{ $t("India's Premier IT Training Institute") }}
                    </div>

                    <h1 class="hero-stagger-2 font-extrabold text-white leading-tight mb-6"
                        style="font-family: 'Lexend', sans-serif; font-size: clamp(2.25rem, 5.5vw, 4rem); letter-spacing: -0.02em;">
                        {{ $t('Launch Your') }} <br class="hidden md:block" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-yellow-400 filter drop-shadow-[0_0_15px_rgba(249,115,22,0.4)]">
                            {{ $t('Tech Career') }}
                        </span>
                        {{ $t('Today') }}
                    </h1>

                    <p class="hero-stagger-3 text-white/70 max-w-[550px] mx-auto md:mx-0 mb-6 text-base md:text-lg font-light leading-relaxed">
                        {{ $t('Master the most in-demand skills in') }} <span class="text-white font-medium">{{ $t('Full-Stack Development') }}</span>, <span class="text-white font-medium">{{ $t('Data Science') }}</span>, <span class="text-white font-medium">{{ $t('Cloud Computing') }}</span>, {{ $t('and') }} <span class="text-white font-medium">{{ $t('Cybersecurity') }}</span>.
                    </p>

                    <p class="hero-stagger-4 flex items-center justify-center md:justify-start gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3 mb-10 backdrop-blur-sm">
                        <span class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-slate-900" src="/public/assets/images/profile/ambassador.jpg" alt="Student" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' viewBox=\\\'0 0 24 24\\\' fill=\\\'white\\\'%3E%3Ccircle cx=\\\'12\\\' cy=\\\'12\\\' r=\\\'12\\\' fill=\\\'%23475569\\\'/%3E%3C/svg%3E'" />
                            <img class="w-8 h-8 rounded-full border-2 border-slate-900" src="/public/assets/images/profile/ambassador1.jpg" alt="Student" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\\\'http://www.w3.org/2000/svg\\\' viewBox=\\\'0 0 24 24\\\' fill=\\\'white\\\'%3E%3Ccircle cx=\\\'12\\\' cy=\\\'12\\\' r=\\\'12\\\' fill=\\\'%23334155\\\'/%3E%3C/svg%3E'" />
                            <div class="w-8 h-8 rounded-full border-2 border-slate-900 bg-orange-500 flex items-center justify-center text-xs font-bold text-white shadow-lg">50+</div>
                        </span>
                        <span class="text-white/80 text-sm font-medium">
                            {{ $t('Students placed at top tech companies') }}
                        </span>
                    </p>

                    <div class="hero-stagger-5 flex flex-wrap items-center justify-center md:justify-start gap-5 mb-8">
                        <router-link :to="heroPrimaryLink"
                            class="group relative inline-flex items-center justify-center px-8 py-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold text-base shadow-[0_0_20px_rgba(249,115,22,0.4)] overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(249,115,22,0.6)]">
                            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></span>
                            <span class="relative flex items-center gap-2">
                                {{ heroPrimaryLabel }}
                                <i class="bi bi-arrow-right-short text-2xl leading-none transition-transform group-hover:translate-x-1"></i>
                            </span>
                        </router-link>
                        <router-link v-if="!isLoggedIn" to="/programs"
                            class="inline-flex items-center gap-2 text-white/70 hover:text-white font-semibold text-base transition-colors hover:translate-x-1 duration-300">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <i class="bi bi-play-fill text-xl text-orange-400"></i>
                            </div>
                            {{ $t('Explore Courses') }}
                        </router-link>
                    </div>

                    <p class="hero-stagger-6 text-white/50 text-sm font-medium flex items-center gap-2">
                        <i class="bi bi-stars text-orange-400 animate-pulse"></i>
                        {{ $t('Next batch starts soon — Limited seats available') }}
                    </p>
                </div>

                <!-- Right: Animated Tech Illustration (desktop) -->
                <!-- Right: Animated Tech Illustration (desktop) -->
                <div class="hidden md:flex items-center justify-center relative" style="min-height: 500px;">
                    <!-- Particle dots -->
                    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                        <span v-for="n in 12" :key="'p'+n"
                              class="absolute w-1.5 h-1.5 rounded-full bg-cyan-400/40 shadow-[0_0_8px_rgba(34,211,238,0.8)]"
                              :style="{ top: (10 + (n * 17) % 80) + '%', left: (10 + (n * 23) % 80) + '%',
                                        animation: 'particle-drift ' + (6 + n % 5) + 's ease-in-out infinite alternate ' + (n * 0.3) + 's' }"></span>
                    </div>

                    <!-- Orb container -->
                    <div class="relative flex items-center justify-center animate-float-slow" style="width: 360px; height: 360px;">
                        <!-- Outer glow pulse -->
                        <div class="absolute rounded-full hero-glow"
                             style="width: 500px; height: 500px; top: -70px; left: -70px;
                                    background: radial-gradient(circle, rgba(14,116,144,0.15) 0%, rgba(249,115,22,0.05) 40%, transparent 70%);"></div>

                        <!-- Ring 1 — main spinning ring -->
                        <div class="absolute rounded-full"
                             style="width: 400px; height: 400px; top: -20px; left: -20px;
                                    border: 2px solid rgba(14,116,144,0.4);
                                    box-shadow: 0 0 40px rgba(14,116,144,0.2), inset 0 0 40px rgba(14,116,144,0.1);
                                    animation: ring-spin 20s linear infinite;"></div>

                        <!-- Ring 2 — dashed, reverse -->
                        <div class="absolute rounded-full"
                             style="width: 440px; height: 440px; top: -40px; left: -40px;
                                    border: 2px dashed rgba(249,115,22,0.25);
                                    animation: ring-spin 30s linear infinite reverse;"></div>

                        <!-- Ring 3 — dotted inner -->
                        <div class="absolute rounded-full"
                             style="width: 360px; height: 360px; top: 0px; left: 0px;
                                    border: 2px dotted rgba(34,211,238,0.3);
                                    animation: ring-spin 15s linear infinite;"></div>

                        <!-- Orb body -->
                        <div class="rounded-full relative overflow-hidden backdrop-blur-md"
                             style="width: 310px; height: 310px;
                                    background: radial-gradient(circle at 35% 35%, rgba(249,115,22,0.3) 0%, rgba(14,116,144,0.4) 50%, rgba(8,15,30,0.8) 100%);
                                    border: 1px solid rgba(255,255,255,0.1);
                                    box-shadow: 0 0 80px rgba(14,116,144,0.3), inset 0 0 60px rgba(249,115,22,0.2);">
                            
                            <!-- Inner glowing core -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-orange-500/20 rounded-full blur-2xl animate-pulse"></div>
                        </div>

                        <!-- SVG circuit detail -->
                        <svg class="absolute z-10 animate-spin-slow-reverse" style="width: 250px; height: 250px; opacity: 0.3;" viewBox="0 0 200 200" fill="none">
                            <path d="M20 100 A80 80 0 0 1 180 100 A80 80 0 0 1 20 100" stroke="rgba(34,211,238,0.8)" stroke-width="1.5" stroke-dasharray="10 15"/>
                            <circle cx="100" cy="100" r="50" stroke="rgba(249,115,22,0.6)" stroke-width="1" fill="none" stroke-dasharray="4 6"/>
                            <circle cx="100" cy="100" r="25" stroke="rgba(255,255,255,0.5)" stroke-width="0.8" fill="none"/>
                            <circle cx="100" cy="100" r="8" stroke="rgba(34,211,238,0.9)" stroke-width="2" fill="rgba(34,211,238,0.2)"/>
                            <line x1="100" y1="20" x2="100" y2="180" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
                            <line x1="20" y1="100" x2="180" y2="100" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
                            <!-- Connector nodes -->
                            <circle cx="100" cy="20" r="3" fill="rgba(249,115,22,0.8)"/>
                            <circle cx="100" cy="180" r="3" fill="rgba(249,115,22,0.8)"/>
                            <circle cx="20" cy="100" r="3" fill="rgba(34,211,238,0.8)"/>
                            <circle cx="180" cy="100" r="3" fill="rgba(34,211,238,0.8)"/>
                        </svg>
                    </div>

                    <!-- Floating tech icons — enhanced glassmorphism -->
                    <div class="hero-icon-float hover:scale-110 transition-transform" style="top: 5%; left: 8%;">
                        <div class="bg-white/5 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 shadow-xl shadow-cyan-500/20">
                            <span class="text-cyan-400 font-mono text-lg font-extrabold">&lt;/&gt;</span>
                        </div>
                    </div>
                    <div class="hero-icon-float hover:scale-110 transition-transform" style="top: -2%; right: 12%; animation-delay: 0.7s;">
                        <div class="bg-white/5 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 shadow-xl shadow-sky-500/20">
                            <i class="bi bi-cloud-arrow-up-fill text-sky-400 text-2xl"></i>
                        </div>
                    </div>
                    <div class="hero-icon-float hover:scale-110 transition-transform" style="bottom: 12%; left: -2%; animation-delay: 1.4s;">
                        <div class="bg-white/5 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 shadow-xl shadow-emerald-500/20">
                            <i class="bi bi-database-fill text-emerald-400 text-2xl"></i>
                        </div>
                    </div>
                    <div class="hero-icon-float hover:scale-110 transition-transform" style="bottom: 4%; right: 8%; animation-delay: 2.1s;">
                        <div class="bg-white/5 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 shadow-xl shadow-orange-500/20">
                            <i class="bi bi-braces text-orange-400 text-2xl"></i>
                        </div>
                    </div>
                    <div class="hero-icon-float hover:scale-110 transition-transform" style="top: 45%; left: -8%; animation-delay: 1.1s;">
                        <div class="bg-white/5 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 shadow-xl shadow-purple-500/20">
                            <i class="bi bi-shield-lock-fill text-purple-400 text-2xl"></i>
                        </div>
                    </div>
                    <div class="hero-icon-float hover:scale-110 transition-transform" style="top: 32%; right: -5%; animation-delay: 1.8s;">
                        <div class="bg-white/5 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 shadow-xl shadow-yellow-500/20">
                            <i class="bi bi-cpu-fill text-yellow-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Bar -->
        <div ref="statsBarRef" class="relative z-10 w-full border-t border-white/10 bg-black/80 backdrop-blur-md">
            <div class="py-8 px-0" style="box-shadow: 0 -12px 40px rgba(0,0,0,0.25);">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="grid grid-cols-4 gap-6">
                        <div v-for="(stat, idx) in heroStats" :key="stat.label" class="flex flex-col items-center text-center">
                            <span v-if="stat.isLive"
                                  class="inline-block w-2 h-2 rounded-full bg-green-400 mb-2"
                                  style="box-shadow: 0 0 8px rgba(74, 222, 128, 0.6); animation: pulse-dot 2s ease-in-out infinite;"></span>
                            <span class="text-white font-extrabold leading-none tracking-tight"
                                  style="font-size: clamp(1.75rem, 4.5vw, 2.85rem); text-shadow: 0 2px 12px rgba(0,0,0,0.35);">
                                {{ stat.displayValue }}
                            </span>
                            <span class="w-[52px] h-[3px] my-3 rounded-sm bg-gradient-to-r from-primary-400 to-primary-300"></span>
                            <span class="text-white/75 font-medium" style="font-size: clamp(0.85rem, 1.8vw, 1.05rem);">
                                {{ stat.label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, reactive, ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const authStore = useAuthStore();
const masterStore = useMasterStore();
const isLoggedIn = computed(() => !!authStore.authToken);

const heroCompanyPartners = ref([]);
const hasPartnerBg = computed(() => heroCompanyPartners.value.length > 0);

const heroPrimaryLabel = computed(() => masterStore?.masterData?.hero_primary_button_text || t("Start Your Tech Career"));
const heroPrimaryLink = computed(() => masterStore?.masterData?.hero_primary_button_url || "/programs");

const statsBarRef = ref(null);
const hasAnimated = ref(false);

function parseStat(rawValue) {
    const match = rawValue.match(/^([\d,]+)(.*)$/);
    if (!match) return { number: 0, suffix: rawValue, displayValue: rawValue };
    return { number: parseInt(match[1].replace(/,/g, ""), 10), suffix: match[2], displayValue: "0" + match[2] };
}

const statsData = reactive([
    { ...parseStat("50+"), label: t("Students Placed"), isLive: false },
    { ...parseStat("10+"), label: t("Expert Mentors"), isLive: false },
    { ...parseStat("25+"), label: t("Industry Partners"), isLive: false },
    { ...parseStat("100+"), label: t("Students Learning"), isLive: true },
]);

const heroStats = computed(() => {
    const provided = masterStore?.masterData?.hero_stats;
    if (provided?.length) {
        const merged = provided.slice(0, 3).map((s) => ({ ...parseStat(s.value), label: s.label, isLive: false }));
        merged.push({ ...parseStat("100+"), label: t("Students Learning"), isLive: true });
        return merged;
    }
    return statsData;
});

function easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); }

function startAnimation() {
    if (hasAnimated.value) return;
    hasAnimated.value = true;
    const stats = heroStats.value;
    const duration = 2000;
    let startTime = null;
    function tick(timestamp) {
        if (!startTime) startTime = timestamp;
        const progress = Math.min((timestamp - startTime) / duration, 1);
        const eased = easeOutCubic(progress);
        for (const stat of stats) stat.displayValue = Math.round(stat.number * eased).toLocaleString("en-IN") + stat.suffix;
        if (progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
}

let observer = null;

onMounted(async () => {
    try {
        const res = await axios.get("/home/company-partners", { headers: { Accept: "application/json" } });
        heroCompanyPartners.value = res.data?.data?.company_partners ?? [];
    } catch {}

    if (statsBarRef.value) {
        observer = new IntersectionObserver((entries) => {
            for (const entry of entries) { if (entry.isIntersecting) { startAnimation(); observer.disconnect(); break; } }
        }, { threshold: 0.3 });
        observer.observe(statsBarRef.value);
    }
});

onUnmounted(() => { if (observer) observer.disconnect(); });
</script>

<style scoped>
@keyframes hero-marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.3); }
}
@keyframes ring-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes hero-stagger-in {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}
/* Orb glow breathing — lightweight, only scales opacity */
@keyframes hero-glow-pulse {
    0%, 100% { opacity: 0.5; transform: scale(1); filter: blur(40px); }
    50% { opacity: 0.9; transform: scale(1.05); filter: blur(50px); }
}
.hero-glow { animation: hero-glow-pulse 6s ease-in-out infinite; }
/* Floating icons — smooth 3d bob */
@keyframes hero-icon-bob {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50% { transform: translateY(-15px) rotate(3deg); }
}
@keyframes float-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
.animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
.animate-spin-slow-reverse { animation: ring-spin 25s linear infinite reverse; }
.animate-pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }


.hero-icon-float {
    position: absolute;
    animation: hero-icon-bob 4s ease-in-out infinite;
}
/* Particle drift */
@keyframes particle-drift {
    0%, 100% { transform: translate(0, 0); opacity: 0.3; }
    50% { transform: translate(6px, -10px); opacity: 0.6; }
}
/* Entrance animations (one-time) */
.hero-stagger-1 { opacity: 0; animation: hero-stagger-in 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards; }
.hero-stagger-2 { opacity: 0; animation: hero-stagger-in 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards; }
.hero-stagger-3 { opacity: 0; animation: hero-stagger-in 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards; }
.hero-stagger-4 { opacity: 0; animation: hero-stagger-in 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.7s forwards; }
.hero-stagger-5 { opacity: 0; animation: hero-stagger-in 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.9s forwards; }
.hero-stagger-6 { opacity: 0; animation: hero-stagger-in 0.7s cubic-bezier(0.16, 1, 0.3, 1) 1.1s forwards; }
</style>
