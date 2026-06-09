<template>
    <section class="landing-hero position-relative">
        <div class="hero-bg">
            <div class="container position-relative hero-content">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <span class="hero-badge">
                            {{ $t('Welcome To Online School') }}
                        </span>

                        <h1 class="hero-heading fw-bold">
                            <span class="d-block">{{ $t('The Best Program') }}</span>
                            <span class="d-block">{{ $t('Enroll for Exchange') }}</span>
                        </h1>

                        <div class="hero-actions d-flex flex-wrap align-items-center gap-3 justify-content-center justify-content-lg-start">
                            <router-link :to="applyLink" class="hero-btn hero-btn--primary">
                                <span>{{ $t('Get Started') }}</span>
                                <span class="hero-btn__arrow" aria-hidden="true">
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </router-link>
                            <router-link to="/courses" class="hero-btn hero-btn--video text-decoration-none">
                                <span class="hero-btn__play" aria-hidden="true">
                                    <i class="bi bi-play-fill"></i>
                                </span>
                                <span>{{ $t('Watch Video') }}</span>
                            </router-link>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-visual">
                            <div class="hero-visual__shape" aria-hidden="true">
                                <span class="hero-visual__arc hero-visual__arc--orange"></span>
                                <span class="hero-visual__arc hero-visual__arc--blue"></span>
                                <span class="hero-visual__arc hero-visual__arc--purple"></span>
                            </div>

                            <div class="hero-visual__photo">
                                <img
                                    :src="heroImage"
                                    class="hero-visual__person"
                                    :alt="activeProgram?.title ?? $t('Program banner')"
                                    loading="lazy"
                                />
                            </div>

                            <div class="hero-float-card hero-float-card--enroll">
                                <div class="hero-float-card__avatars" aria-hidden="true">
                                    <span class="hero-float-card__avatar hero-float-card__avatar--1"></span>
                                    <span class="hero-float-card__avatar hero-float-card__avatar--2"></span>
                                    <span class="hero-float-card__avatar hero-float-card__avatar--3"></span>
                                    <span class="hero-float-card__avatar hero-float-card__avatar--plus">
                                        <i class="bi bi-plus"></i>
                                    </span>
                                </div>
                                <span class="hero-float-card__text">
                                    <strong>{{ enrollCount }}+</strong> {{ $t('User Enroll') }}
                                </span>
                            </div>

                            <span class="hero-brand-icon hero-brand-icon--google" aria-hidden="true">
                                <i class="bi bi-google"></i>
                            </span>
                            <span class="hero-brand-icon hero-brand-icon--youtube" aria-hidden="true">
                                <i class="bi bi-youtube"></i>
                            </span>
                            <span class="hero-brand-icon hero-brand-icon--meet" aria-hidden="true">
                                <i class="bi bi-camera-video-fill"></i>
                            </span>

                            <div class="hero-books" aria-hidden="true">
                                <span class="hero-books__book hero-books__book--1"></span>
                                <span class="hero-books__book hero-books__book--2"></span>
                                <span class="hero-books__book hero-books__book--3"></span>
                            </div>
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
}

.hero-bg {
    position: relative;
    overflow: hidden;
    padding: 1.5rem 6rem 0 6rem;
    background:
        radial-gradient(ellipse 55% 70% at 0% 50%, rgba(255, 200, 190, 0.45) 0%, transparent 60%),
        radial-gradient(ellipse 50% 60% at 100% 40%, rgba(180, 230, 210, 0.35) 0%, transparent 55%),
        radial-gradient(ellipse 40% 50% at 85% 80%, rgba(190, 220, 255, 0.35) 0%, transparent 50%),
        linear-gradient(180deg, #2cab4d 0%, #f7fff6 100%);
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
    color: #111827;
    font-size: clamp(2rem, 4.5vw, 3.25rem);
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin-bottom: 2rem;
    max-width: 520px;
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
    background-size: cover;
    background-position: center;

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

.hero-float-card--enroll {
    animation-name: hero-float-center;
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

.hero-trust-bar {
    margin-top: 3rem;
    padding-top: 1.5rem;
    color: #9ca3af;
    font-size: 0.88rem;
    font-weight: 500;
    line-height: 1.5;
}

@media (max-width: 991px) {
    .hero-bg {
        padding: 1.5rem 1.5rem 0;
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
    .hero-actions {
        flex-direction: column;
        align-items: stretch !important;
    }

    .hero-btn--primary,
    .hero-btn--video {
        justify-content: center;
    }

    .hero-visual {
        min-height: 300px;
    }

    .hero-brand-icon {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }

    .hero-trust-bar {
        font-size: 0.8rem;
        margin-top: 2rem;
    }
}
</style>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useMasterStore } from "@/stores/master";

const masterStore = useMasterStore();
const programs = ref([]);
const activeIndex = ref(0);

const activeProgram = computed(() => programs.value[activeIndex.value] ?? null);
const applyLink = computed(() => activeProgram.value?.cta_url || "/register");

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

onMounted(async () => {
    try {
        const response = await axios.get("/home/programs");
        programs.value = response.data.data.programs ?? [];
    } catch (error) {
        console.error("Error fetching home programs:", error);
    }
});
</script>
