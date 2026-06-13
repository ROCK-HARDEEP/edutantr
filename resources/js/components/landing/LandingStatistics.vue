<template>
    <section class="landing-stats">
        <div class="colleges-banner">
            <swiper
                v-if="slides.length"
                :modules="[Navigation, Pagination, Autoplay, EffectFade]"
                :slides-per-view="1"
                :space-between="0"
                :speed="800"
                :autoplay="{ delay: 5000, disableOnInteraction: false }"
                :loop="slides.length > 1"
                effect="fade"
                :fade-effect="{ crossFade: true }"
                navigation
                pagination
                class="colleges-banner__swiper"
            >
                <swiper-slide v-for="slide in slides" :key="slide.id">
                    <div class="colleges-banner__slide">
                        <img
                            v-if="slide.isLogo"
                            :src="slide.image"
                            :alt="slide.title"
                            class="colleges-banner__image colleges-banner__image--blur"
                            aria-hidden="true"
                        />
                        <img
                            :src="slide.image"
                            :alt="slide.title"
                            class="colleges-banner__image"
                            :class="{ 'colleges-banner__image--logo': slide.isLogo }"
                            loading="lazy"
                        />
                        <div class="colleges-banner__overlay" aria-hidden="true"></div>
                        <div class="colleges-banner__caption">
                            <span class="colleges-banner__eyebrow">
                                <i class="bi bi-mortarboard-fill me-1"></i>
                                {{ slide.eyebrow }}
                            </span>
                            <h3 class="colleges-banner__title">{{ slide.title }}</h3>
                            <p v-if="slide.subtitle" class="colleges-banner__subtitle">{{ slide.subtitle }}</p>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>

            <div v-else-if="loading" class="colleges-banner__loading">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">{{ $t('Loading') }}</span>
                </div>
            </div>

            <div v-else class="colleges-banner__empty">
                <i class="bi bi-images colleges-banner__empty-icon"></i>
                <p class="text-muted mb-0">{{ $t('Partner colleges coming soon.') }}</p>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.landing-stats {
    height: 100vh;
    min-height: 100vh;
    max-height: 100vh;
    padding: 0;
    overflow: hidden;
    background: #0f172a;
}

.colleges-banner {
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #0f172a;
}

.colleges-banner__swiper {
    width: 100%;
    height: 100%;
}

.colleges-banner__swiper :deep(.swiper-wrapper),
.colleges-banner__swiper :deep(.swiper-slide) {
    height: 100%;
}

.colleges-banner__slide {
    position: relative;
    width: 100%;
    height: 100%;
}

.colleges-banner__image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.colleges-banner__image--blur {
    position: absolute;
    inset: 0;
    filter: blur(28px) brightness(0.55);
    transform: scale(1.08);
    object-fit: cover;
}

.colleges-banner__image--logo {
    position: relative;
    z-index: 1;
    width: auto;
    max-width: min(420px, 80vw);
    max-height: min(280px, 45vh);
    margin: auto;
    object-fit: contain;
    padding: 2rem;
}

.colleges-banner__slide:has(.colleges-banner__image--logo) {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f172a;
}

.colleges-banner__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        180deg,
        rgba(15, 23, 42, 0.1) 0%,
        rgba(15, 23, 42, 0.35) 55%,
        rgba(15, 23, 42, 0.78) 100%
    );
    pointer-events: none;
}

.colleges-banner__caption {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    padding: 2rem clamp(1.25rem, 4vw, 3rem) clamp(4.5rem, 8vw, 6rem);
    color: #fff;
}

.colleges-banner__eyebrow {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.95rem;
    border-radius: 50px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(8px);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 0.85rem;
}

.colleges-banner__title {
    margin: 0;
    max-width: 720px;
    font-size: clamp(1.5rem, 4vw, 2.75rem);
    font-weight: 700;
    line-height: 1.2;
    text-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
}

.colleges-banner__subtitle {
    margin: 0.65rem 0 0;
    max-width: 560px;
    font-size: clamp(0.95rem, 2vw, 1.1rem);
    color: rgba(255, 255, 255, 0.82);
    line-height: 1.5;
}

.colleges-banner__loading,
.colleges-banner__empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    width: 100%;
    height: 100%;
    background: #f1f5f9;
}

.colleges-banner__empty-icon {
    font-size: 2.5rem;
    color: #94a3b8;
}

.colleges-banner :deep(.swiper-button-next),
.colleges-banner :deep(.swiper-button-prev) {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(255, 255, 255, 0.4);
    color: #15803d;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15);
    transition: transform 0.25s ease, background 0.25s ease;

    &::after {
        font-size: 1rem;
        font-weight: 700;
    }

    &:hover {
        transform: scale(1.06);
        background: #fff;
    }
}

.colleges-banner :deep(.swiper-button-prev) {
    left: clamp(0.75rem, 2vw, 1.5rem);
}

.colleges-banner :deep(.swiper-button-next) {
    right: clamp(0.75rem, 2vw, 1.5rem);
}

.colleges-banner :deep(.swiper-pagination) {
    bottom: clamp(1.25rem, 3vw, 2rem);
}

.colleges-banner :deep(.swiper-pagination-bullet) {
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.45);
    opacity: 1;
    transition: width 0.25s ease, background 0.25s ease;
}

.colleges-banner :deep(.swiper-pagination-bullet-active) {
    width: 28px;
    border-radius: 6px;
    background: #fff;
}

@media (max-width: 767px) {
    .colleges-banner :deep(.swiper-button-next),
    .colleges-banner :deep(.swiper-button-prev) {
        width: 40px;
        height: 40px;

        &::after {
            font-size: 0.85rem;
        }
    }

    .colleges-banner__caption {
        padding-bottom: 4.25rem;
    }
}
</style>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay, EffectFade } from "swiper/modules";

const { t } = useI18n();

const loading = ref(true);
const galleryItems = ref([]);
const colleges = ref([]);

const slides = computed(() => {
    if (galleryItems.value.length) {
        return galleryItems.value.map((item) => ({
            id: `gallery-${item.id}`,
            image: item.media_url,
            title: item.title || item.college?.name || t("Partner College"),
            subtitle: item.college?.name && item.title ? item.college.name : item.description || item.college?.location || "",
            eyebrow: item.section_label || t("Partner College"),
            isLogo: false,
        }));
    }

    return colleges.value.map((college) => ({
        id: `college-${college.id}`,
        image: college.logo,
        title: college.name,
        subtitle: college.location || college.description || "",
        eyebrow: t("Partner College"),
        isLogo: true,
    }));
});

onMounted(async () => {
    try {
        const [galleryRes, collegesRes] = await Promise.all([
            axios.get("/home/partner-college-gallery"),
            axios.get("/home/partner-colleges"),
        ]);

        galleryItems.value = galleryRes.data.data.slides ?? [];
        colleges.value = collegesRes.data.data.colleges ?? [];
    } catch (error) {
        console.error("Error fetching partner college slider:", error);
    } finally {
        loading.value = false;
    }
});
</script>
