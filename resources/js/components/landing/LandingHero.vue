<template>
    <section class="landing-hero position-relative landing-hero--partners">
        <div class="hero-bg hero-bg--cinematic">
            <div v-if="hasPartnerBg" class="hero-partners-scroll" aria-hidden="true">
                <div class="hero-partners-track" :style="{ '--partners-duration': `${partnersScrollDuration}s` }">
                    <div
                        v-for="stripIndex in 2"
                        :key="`partners-strip-${stripIndex}`"
                        class="hero-partners-strip"
                        :aria-hidden="stripIndex === 2 ? 'true' : undefined"
                    >
                        <div
                            v-for="(item, index) in partners"
                            :key="`partner-${stripIndex}-${item.id ?? index}`"
                            class="hero-partners-cell"
                        >
                            <img
                                :src="item.logo"
                                :alt="item.name"
                                loading="eager"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-cinematic-overlay" aria-hidden="true"></div>

            <div class="container hero-content hero-content--cinematic">
                <div class="hero-cinematic-copy text-center">
                    

                    <h1 class="hero-heading hero-heading--cinematic">
                        {{ $t('From beginner to skilled—starting in') }}
                        <em class="hero-heading-accent">{{ $t('minutes') }}</em>.
                    </h1>

                    <p class="hero-cinematic-subtitle">
                        {{ $t('Fueling the Next Generation of Entrepreneurs') }}
                    </p>

                    <div class="hero-actions hero-actions--center">
                        <router-link :to="heroPrimaryLink" class="hero-cta-orange">
                            {{ heroPrimaryLabel }}
                        </router-link>
                        <router-link v-if="!isLoggedIn" to="/courses" class="hero-cta-ghost text-decoration-none">
                            <i class="bi bi-play-circle me-2"></i>
                            {{ $t('Check Our Courses') }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="three_column_section">
            <div class="three_column_section__panel">
                <div class="container">
                    <div class="three_column_section__grid">
                        <div
                            v-for="stat in heroStats"
                            :key="stat.label"
                            class="three_column_section__item"
                        >
                            <span class="three_column_section__value">{{ stat.value }}</span>
                            <span class="three_column_section__line" aria-hidden="true"></span>
                            <span class="three_column_section__label">{{ stat.label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.landing-hero {
    margin-bottom: 0;
    min-height: 100vh;
}

.landing-hero--partners {
    margin-top: 0;
    min-height: 100vh;
    overflow: hidden;
}

.landing-hero__top {
    position: relative;
    z-index: 10;
    flex-shrink: 0;
    padding-top: 5rem;
}

.landing-hero__top--classic {
    padding-top: 5rem;
}

/* ─── Cinematic partner background (auto-scrolling logos) ─── */
.hero-bg--cinematic {
    position: relative;
    min-height: 100vh;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #0a0a0a;
    padding: 5rem 0 10rem;
    box-sizing: border-box;
}

.hero-partners-scroll {
    position: absolute;
    inset: 0;
    overflow: hidden;
    z-index: 0;
}

.hero-partners-track {
    display: flex;
    height: 100%;
    width: max-content;
    animation: hero-partners-marquee var(--partners-duration, 30s) linear infinite;
}

.hero-partners-strip {
    display: flex;
    width: 100vw;
    height: 100%;
    flex-shrink: 0;
}

.hero-partners-cell {
    flex: 1 1 0;
    min-width: 0;
    height: 100%;
    overflow: hidden;
    border-right: 1px solid rgba(255, 255, 255, 0.06);

    &:last-child {
        border-right: none;
    }
}

.hero-partners-cell img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    filter: grayscale(10%) contrast(1.05);
}

@keyframes hero-partners-marquee {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
}

.hero-cinematic-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background:
        radial-gradient(ellipse 70% 60% at 50% 45%, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.72) 100%),
        linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.65) 50%, rgba(0, 0, 0, 0.8) 100%);
}

.hero-content--cinematic {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 1.5rem 1rem;
}

.three_column_section {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 5;
    width: 100%;
    pointer-events: none;
}

.three_column_section__panel {
    pointer-events: auto;
    width: 100%;
    padding: 2rem 0 2.25rem;
    background: rgba(0, 0, 0, 0.42);
    backdrop-filter: blur(10px);
    box-shadow: 0 -12px 40px rgba(0, 0, 0, 0.25);
}

.three_column_section__link {
    display: block;
    margin-bottom: 1.5rem;
    text-align: center;
    font-size: 0.95rem;
    font-weight: 600;
    color: #4ade80;
    transition: color 0.2s ease;

    &:hover {
        color: #86efac;
    }
}

.three_column_section__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.5rem;
}

.three_column_section__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.three_column_section__value {
    font-size: clamp(2rem, 4.5vw, 2.85rem);
    font-weight: 800;
    color: #ffffff;
    line-height: 1;
    letter-spacing: -0.03em;
    text-shadow: 0 2px 12px rgba(0, 0, 0, 0.35);
}

.three_column_section__line {
    display: block;
    width: 52px;
    height: 3px;
    margin: 0.75rem auto 0.85rem;
    border-radius: 2px;
    background: linear-gradient(90deg, #22c55e, #4ade80);
}

.three_column_section__label {
    font-size: clamp(0.95rem, 1.8vw, 1.1rem);
    font-weight: 500;
    color: rgba(255, 255, 255, 0.78);
    line-height: 1.35;
}

.hero-cinematic-copy {
    padding: 1rem 0;
}

.hero-badge--light {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
}

.hero-heading--cinematic {
    font-family: Georgia, "Times New Roman", Times, serif;
    font-weight: 400;
    margin-left: auto;
    margin-right: auto;
    max-width: 820px;
}

.hero-heading-accent {
    font-style: italic;
    color: #f97316;
    font-weight: 400;
}

.hero-cinematic-subtitle {
    margin: 0 auto 2rem;
    max-width: 520px;
    font-size: clamp(0.95rem, 2vw, 1.1rem);
    color: rgba(255, 255, 255, 0.55);
    font-weight: 400;
    letter-spacing: 0.02em;
}

.hero-actions--center {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 1rem 1.25rem;
}

.hero-cta-orange {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.85rem 2.25rem;
    border-radius: 8px;
    background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%);
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    box-shadow: 0 8px 28px rgba(234, 88, 12, 0.45);
    transition: transform 0.25s ease, box-shadow 0.25s ease;

    &:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 36px rgba(234, 88, 12, 0.55);
    }
}

.hero-cta-ghost {
    display: inline-flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.75);
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.2s ease;

    &:hover {
        color: #fff;
    }
}

/* ─── Classic hero (fallback) ─── */
.hero-bg--classic {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    padding: 0 6rem 2rem;
    background:
        radial-gradient(ellipse 55% 70% at 0% 50%, rgba(255, 200, 190, 0.45) 0%, transparent 60%),
        radial-gradient(ellipse 50% 60% at 100% 40%, rgba(180, 230, 210, 0.35) 0%, transparent 55%),
        radial-gradient(ellipse 40% 50% at 85% 80%, rgba(190, 220, 255, 0.35) 0%, transparent 50%),
        linear-gradient(180deg, #2cab4d 0%, #f7fff6 100%);
}

.hero-bg--classic .hero-content {
    flex: 1;
    display: flex;
    align-items: center;
    padding-top: 1.5rem;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-block;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    background: #339b0b;
    color: #fff;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    margin-bottom: 1.25rem;
}

.hero-heading {
    color: #81e5a9;
    font-size: clamp(2rem, 4.5vw, 3.25rem);
}

.hero-actions {
    margin-bottom: 0.5rem;
}

.hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    border: none;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.hero-btn:hover {
    transform: translateY(-2px);
}

.hero-btn--primary {
    padding: 0.65rem 0.65rem 0.65rem 1.5rem;
    border-radius: 50px;
    background: #111827;
    color: #fff;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(17, 24, 39, 0.2);

    &:hover {
        color: #fff;
        box-shadow: 0 12px 32px rgba(17, 24, 39, 0.28);
    }
}

.hero-btn__arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fff;
    color: #111827;
    font-size: 1rem;
}

.hero-btn--video {
    color: #374151;
    font-weight: 600;
    font-size: 0.95rem;

    &:hover {
        color: #ff3b5c;
    }
}

.hero-btn__play {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #339b0b;
    color: #fff;
    font-size: 1.1rem;
    padding-left: 3px;
    box-shadow: 0 6px 20px rgba(255, 59, 92, 0.35);
}

.hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 460px;
    min-height: 440px;
    margin: 0 auto;
}

.hero-visual__shape {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 88%;
    aspect-ratio: 1;
    z-index: 0;
}

.hero-visual__arc {
    position: absolute;
    border-radius: 50%;

    &--orange {
        inset: 0;
        background: conic-gradient(from 210deg, #f5a623 0deg 120deg, transparent 120deg);
    }

    &--blue {
        inset: 0;
        background: conic-gradient(from 30deg, #2563eb 0deg 130deg, transparent 130deg);
    }

    &--purple {
        inset: 0;
        background: conic-gradient(from 130deg, #a78bfa 0deg 80deg, transparent 80deg);
        opacity: 0.85;
    }
}

.hero-visual__photo {
    position: relative;
    z-index: 2;
    width: 78%;
    aspect-ratio: 1;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 6px solid #fff;
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
}

.hero-visual__person {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
}

.hero-float-card {
    position: absolute;
    z-index: 4;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.6rem 1rem;
    background: #fff;
    border-radius: 50px;
    box-shadow: 0 8px 28px rgba(15, 23, 42, 0.12);
    animation: hero-float 4s ease-in-out infinite;
}

.hero-float-card--enroll {
    top: 6%;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    animation-name: hero-float-center;
}

.hero-float-card__avatars {
    display: flex;
    align-items: center;
}

.hero-float-card__avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #fff;
    margin-left: -8px;

    &:first-child {
        margin-left: 0;
    }

    &--1 {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
    }

    &--2 {
        background: linear-gradient(135deg, #60a5fa, #2563eb);
    }

    &--3 {
        background: linear-gradient(135deg, #f472b6, #ec4899);
    }

    &--plus {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ff3b5c;
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
    }
}

.hero-float-card__text {
    font-size: 0.82rem;
    color: #374151;
    font-weight: 500;

    strong {
        color: #111827;
        font-weight: 700;
    }
}

.hero-brand-icon {
    position: absolute;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.1);
    font-size: 1.15rem;
    animation: hero-float 5s ease-in-out infinite;

    &--google {
        top: 38%;
        left: -2%;
        color: #4285f4;
        animation-delay: 0.5s;
    }

    &--youtube {
        top: 8%;
        right: 8%;
        color: #ff0000;
        animation-delay: 1s;
    }

    &--meet {
        bottom: 28%;
        right: 0;
        color: #00897b;
        animation-delay: 1.5s;
    }
}

.hero-books {
    position: absolute;
    bottom: 8%;
    left: 12%;
    z-index: 3;
    display: flex;
    align-items: flex-end;
    gap: 3px;
    animation: hero-float 4.5s ease-in-out infinite;
    animation-delay: 0.8s;
}

.hero-books__book {
    display: block;
    border-radius: 3px 3px 2px 2px;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);

    &--1 {
        width: 14px;
        height: 38px;
        background: #f5a623;
        transform: rotate(-8deg);
    }

    &--2 {
        width: 16px;
        height: 44px;
        background: #7dd3fc;
        margin-bottom: 4px;
    }

    &--3 {
        width: 14px;
        height: 36px;
        background: #2563eb;
        transform: rotate(6deg);
    }
}

@keyframes hero-float {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-8px);
    }
}

@keyframes hero-float-center {
    0%,
    100% {
        transform: translateX(-50%) translateY(0);
    }
    50% {
        transform: translateX(-50%) translateY(-8px);
    }
}

@media (max-width: 991px) {
    .hero-bg--classic {
        padding: 0 1.5rem 2rem;
    }

    .hero-bg--cinematic {
        min-height: 580px;
        padding-top: 4.5rem;
        padding-bottom: 13rem;
    }

    .hero-content--cinematic {
        padding: 1.5rem 1rem 0.5rem;
    }

    .three_column_section__panel {
        padding: 1.5rem 0 1.75rem;
    }

    .three_column_section__grid {
        gap: 0.75rem;
    }

    .three_column_section__line {
        width: 36px;
        margin: 0.55rem auto 0.65rem;
    }

    .hero-columns {
        grid-template-columns: repeat(3, 1fr);
    }

    .hero-columns__panel:nth-child(n + 4) {
        display: none;
    }

    .hero-heading {
        margin-left: auto;
        margin-right: auto;
    }

    .hero-visual {
        min-height: 360px;
        max-width: 400px;
    }

    .hero-brand-icon--google {
        left: 2%;
    }
}

@media (max-width: 575px) {
    .three_column_section__grid {
        grid-template-columns: 1fr;
        gap: 1.1rem;
    }

    .three_column_section__item:not(:last-child) {
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .hero-bg--cinematic {
        padding-bottom: 18rem;
    }

    .hero-actions {
        flex-direction: column;
        align-items: stretch !important;
    }

    .hero-btn--primary,
    .hero-btn--video,
    .hero-cta-orange {
        justify-content: center;
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
    }

    .hero-visual {
        min-height: 300px;
    }

    .hero-brand-icon {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }
}
</style>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";

const { t } = useI18n();
const authStore = useAuthStore();

const masterStore = useMasterStore();
const programs = ref([]);
const partners = ref([]);
const collegePartnerCount = ref(0);
const activeIndex = ref(0);

const normalizeApiList = (payload) => {
    if (Array.isArray(payload)) {
        return payload;
    }

    if (payload && Array.isArray(payload.data)) {
        return payload.data;
    }

    return [];
};

const hasPartnerBg = computed(() => partners.value.length > 0);

const partnersScrollDuration = computed(() =>
    Math.max(18, partners.value.length * 5)
);

const activeProgram = computed(() => programs.value[activeIndex.value] ?? null);
const isLoggedIn = computed(() => Boolean(authStore.authToken));

const heroPrimaryLink = computed(() => {
    if (isLoggedIn.value) {
        return "/courses";
    }

    return activeProgram.value?.cta_url || "/register";
});

const heroPrimaryLabel = computed(() => {
    if (isLoggedIn.value) {
        return t("Browse Courses");
    }

    if (hasPartnerBg.value) {
        return activeProgram.value?.cta_label || t("Explore Programs");
    }

    return t("Get Started");
});

const heroImage = computed(
    () => activeProgram.value?.image ?? masterStore?.masterData?.hero_thumbnail ?? "/assets/website/banner-hero.png"
);

const enrollCount = computed(() => {
    const count = masterStore?.masterData?.total_enrollments;
    if (!count) return "15k";
    const num = parseInt(String(count).replace(/\D/g, ""), 10);
    if (num >= 1000) return `${Math.floor(num / 1000)}k`;
    return count;
});

const formatStatCount = (value, fallback = "10") => {
    const num = parseInt(String(value ?? "").replace(/\D/g, ""), 10);
    if (!num || Number.isNaN(num)) {
        return `${fallback}+`;
    }
    if (num >= 1000) {
        return `${Math.floor(num / 1000)}k+`;
    }
    return `${num}+`;
};

const heroStats = computed(() => [
    {
        value: formatStatCount(
            masterStore?.masterData?.total_student ?? masterStore?.masterData?.total_enrollments,
            "10"
        ),
        label: t("Students"),
    },
    {
        value: formatStatCount(masterStore?.masterData?.total_instructors, "20"),
        label: t("Instructors"),
    },
    {
        value: formatStatCount(collegePartnerCount.value, "10"),
        label: t("College Partners"),
    },
]);

onMounted(async () => {
    try {
        const [programsRes, partnersRes, collegesRes] = await Promise.all([
            axios.get("/home/programs"),
            axios.get("/home/partner-logos"),
            axios.get("/home/partner-colleges"),
        ]);

        programs.value = programsRes.data.data.programs ?? [];

        const logos = normalizeApiList(partnersRes.data?.data?.logos).sort(
            (a, b) => (a.sort_order ?? 0) - (b.sort_order ?? 0)
        );

        partners.value = logos.filter((item) => item.partner_type === "company");

        const colleges = normalizeApiList(collegesRes.data?.data?.colleges);
        const collegeLogos = logos.filter((item) => item.partner_type === "college");
        collegePartnerCount.value = Math.max(colleges.length, collegeLogos.length);
    } catch (error) {
        console.error("Error fetching landing hero data:", error);
    }
});
</script>
