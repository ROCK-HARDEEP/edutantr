<template>
    <div class="partner-colleges">
        <div class="container partner-colleges__inner">
            <div class="partner-colleges__header text-center">
                <span class="partner-colleges__eyebrow">
                    <i class="bi bi-building-fill"></i>
                    {{ $t('Academic Network') }}
                </span>
                <h2 class="partner-colleges__heading">
                    {{ $t('Our') }}
                    <span class="partner-colleges__heading-accent">{{ $t('Partner Colleges') }}</span>
                </h2>
            </div>

            <div v-if="loading" class="partner-colleges__loading" aria-hidden="true"></div>

            <div v-else-if="colleges.length" class="partner-colleges__showcase">
                <div class="row g-4 g-lg-5 align-items-stretch">
                    <div class="col-12 col-lg-6 partner-colleges__details-col">
                        <div
                            class="partner-colleges__details"
                            @mouseenter="pauseRotation"
                            @mouseleave="resumeRotation"
                        >
                            <Transition name="partner-colleges-fade" mode="out-in">
                                <div :key="activeCollege.id" class="partner-colleges__details-body">
                                    <span class="partner-colleges__badge">
                                        <i class="bi bi-mortarboard-fill"></i>
                                        {{ $t('Partner College') }}
                                    </span>

                                    <h3 class="partner-colleges__name">{{ activeCollege.name }}</h3>

                                    <p v-if="activeCollege.location" class="partner-colleges__location">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        {{ activeCollege.location }}
                                    </p>

                                    <p class="partner-colleges__description">
                                        {{ activeCollege.description || defaultDescription }}
                                    </p>

                                    <div class="partner-colleges__counter">
                                        <span class="partner-colleges__counter-current">
                                            {{ String(activeIndex + 1).padStart(2, '0') }}
                                        </span>
                                        <span class="partner-colleges__counter-sep">/</span>
                                        <span class="partner-colleges__counter-total">
                                            {{ String(colleges.length).padStart(2, '0') }}
                                        </span>
                                    </div>
                                </div>
                            </Transition>

                            <div class="partner-colleges__nav">
                                <button
                                    v-for="(college, index) in colleges"
                                    :key="college.id"
                                    type="button"
                                    class="partner-colleges__dot"
                                    :class="{ 'partner-colleges__dot--active': index === activeIndex }"
                                    :aria-label="college.name"
                                    @click="goTo(index)"
                                ></button>
                            </div>

                            <div class="partner-colleges__progress" aria-hidden="true">
                                <span
                                    class="partner-colleges__progress-bar"
                                    :key="progressKey"
                                    :style="{ animationDuration: `${intervalMs}ms` }"
                                ></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 partner-colleges__media-col">
                        <div
                            class="partner-colleges__media"
                            @mouseenter="pauseRotation"
                            @mouseleave="resumeRotation"
                        >
                            <Transition name="partner-colleges-fade" mode="out-in">
                                <div :key="activeCollege.id" class="partner-colleges__media-frame">
                                    <img
                                        :src="activeCollege.image"
                                        :alt="activeCollege.name"
                                        class="partner-colleges__image"
                                        loading="lazy"
                                    />
                                    <div class="partner-colleges__media-overlay" aria-hidden="true"></div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.partner-colleges {
    position: relative;
    width: 100%;
    padding: 2.5rem 0 0;
    background: linear-gradient(180deg, #ecfdf5 0%, #f8fafc 100%);
}

.partner-colleges__inner {
    position: relative;
}

.partner-colleges__header {
    margin-bottom: 2rem;
}

.partner-colleges__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.9rem;
    border-radius: 50px;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.12), rgba(21, 128, 61, 0.08));
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #15803d;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 0.65rem;
}

.partner-colleges__heading {
    margin: 0;
    font-size: clamp(1.35rem, 2.5vw, 1.85rem);
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
}

.partner-colleges__heading-accent {
    background: linear-gradient(90deg, #15803d, #22c55e, #4ade80);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.partner-colleges__loading {
    width: 100%;
    min-height: 360px;
    border-radius: 24px;
    background: linear-gradient(90deg, #e2e8f0 0%, #f1f5f9 50%, #e2e8f0 100%);
    background-size: 200% 100%;
    animation: partner-colleges-shimmer 1.4s ease-in-out infinite;
}

.partner-colleges__showcase {
    padding-bottom: 0.5rem;
}

.partner-colleges__details {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: clamp(1.5rem, 3vw, 2.5rem);
    background: #fff;
    border-radius: 24px;
    border: 1px solid rgba(34, 197, 94, 0.14);
    box-shadow: 0 12px 36px rgba(15, 23, 42, 0.06);
    min-height: clamp(320px, 38vw, 420px);
}

.partner-colleges__details-body {
    flex: 1;
}

.partner-colleges__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
    background: #ecfdf5;
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #15803d;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.partner-colleges__name {
    margin: 0 0 0.85rem;
    font-size: clamp(1.35rem, 2.5vw, 1.85rem);
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
}

.partner-colleges__location {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    margin: 0 0 1rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #334155;

    i {
        color: #22c55e;
        font-size: 1rem;
    }
}

.partner-colleges__description {
    margin: 0 0 1.5rem;
    font-size: 1rem;
    line-height: 1.7;
    color: #64748b;
    max-width: 520px;
}

.partner-colleges__counter {
    display: inline-flex;
    align-items: baseline;
    gap: 0.15rem;
    font-weight: 800;
    color: #15803d;
    letter-spacing: 0.04em;
}

.partner-colleges__counter-current {
    font-size: 1.5rem;
}

.partner-colleges__counter-sep {
    font-size: 1rem;
    color: #94a3b8;
}

.partner-colleges__counter-total {
    font-size: 0.95rem;
    color: #64748b;
}

.partner-colleges__nav {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1.5rem;
}

.partner-colleges__dot {
    width: 10px;
    height: 10px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: #cbd5e1;
    cursor: pointer;
    transition: width 0.25s ease, background 0.25s ease, transform 0.25s ease;

    &--active {
        width: 28px;
        border-radius: 4px;
        background: #22c55e;
    }

    &:hover {
        transform: scale(1.1);
        background: #86efac;
    }
}

.partner-colleges__progress {
    margin-top: 1.25rem;
    height: 3px;
    border-radius: 3px;
    background: #e2e8f0;
    overflow: hidden;
}

.partner-colleges__progress-bar {
    display: block;
    height: 100%;
    width: 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #15803d, #22c55e, #4ade80);
    animation: partner-colleges-progress linear forwards;
}

.partner-colleges__media {
    height: 100%;
    min-height: clamp(320px, 38vw, 420px);
}

.partner-colleges__media-frame {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: clamp(320px, 38vw, 420px);
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(34, 197, 94, 0.14);
    box-shadow: 0 12px 36px rgba(15, 23, 42, 0.08);
}

.partner-colleges__image {
    display: block;
    width: 100%;
    height: 100%;
    min-height: clamp(320px, 38vw, 420px);
    object-fit: cover;
    object-position: center;
}

.partner-colleges__media-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(15, 23, 42, 0.08) 0%,
        rgba(21, 128, 61, 0.12) 100%
    );
    pointer-events: none;
}

.partner-colleges-fade-enter-active,
.partner-colleges-fade-leave-active {
    transition: opacity 0.45s ease, transform 0.45s ease;
}

.partner-colleges-fade-enter-from {
    opacity: 0;
    transform: translateY(12px);
}

.partner-colleges-fade-leave-to {
    opacity: 0;
    transform: translateY(-12px);
}

@keyframes partner-colleges-shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

@keyframes partner-colleges-progress {
    0% {
        width: 0;
    }
    100% {
        width: 100%;
    }
}

@media (max-width: 991px) {
    .partner-colleges {
        padding-top: 2rem;
    }

    .partner-colleges__header {
        margin-bottom: 1.5rem;
    }

    .partner-colleges__media-col {
        order: -1;
    }

    .partner-colleges__details,
    .partner-colleges__media,
    .partner-colleges__media-frame,
    .partner-colleges__image {
        min-height: 280px;
    }
}

@media (max-width: 575px) {
    .partner-colleges__details {
        padding: 1.25rem;
    }

    .partner-colleges__description {
        font-size: 0.92rem;
    }
}
</style>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const colleges = ref([]);
const loading = ref(true);
const activeIndex = ref(0);
const progressKey = ref(0);
const intervalMs = 2000;
let timer = null;

const defaultDescription = computed(() =>
    t("Partnering with us to deliver quality education and career-ready learning paths.")
);

const activeCollege = computed(() => colleges.value[activeIndex.value] ?? {});

const mapGallerySlides = (items = []) =>
    items
        .filter((item) => item.media_url && !item.is_video)
        .map((item) => ({
            id: `gallery-${item.id}`,
            image: item.media_url,
            name: item.college?.name || item.title || "",
            location: item.college?.location || "",
            description: item.description || "",
        }));

const mergeCollegeSlides = (collegeItems = [], logos = []) => {
    const slides = [];
    const seenNames = new Set();

    const addSlide = (slide) => {
        const key = (slide.name || "").trim().toLowerCase();
        if (!key || !slide.image || seenNames.has(key)) {
            return;
        }
        seenNames.add(key);
        slides.push(slide);
    };

    collegeItems.forEach((college) => {
        addSlide({
            id: `college-${college.id}`,
            image: college.logo,
            name: college.name,
            location: college.location || "",
            description: college.description || "",
        });
    });

    logos
        .filter((logo) => logo.partner_type === "college")
        .forEach((logo) => {
            addSlide({
                id: `logo-${logo.id}`,
                image: logo.logo,
                name: logo.name,
                location: "",
                description: "",
            });
        });

    return slides;
};

const resetProgress = () => {
    progressKey.value += 1;
};

const goTo = (index) => {
    if (!colleges.value.length) {
        return;
    }

    activeIndex.value = index;
    resetProgress();
};

const advanceSlide = () => {
    if (colleges.value.length <= 1) {
        return;
    }

    activeIndex.value = (activeIndex.value + 1) % colleges.value.length;
    resetProgress();
};

const startRotation = () => {
    stopRotation();

    if (colleges.value.length <= 1) {
        return;
    }

    timer = window.setInterval(advanceSlide, intervalMs);
};

const stopRotation = () => {
    if (timer !== null) {
        window.clearInterval(timer);
        timer = null;
    }
};

const pauseRotation = () => {
    stopRotation();
};

const resumeRotation = () => {
    startRotation();
};

onMounted(async () => {
    try {
        const [galleryRes, collegesRes, logosRes] = await Promise.all([
            axios.get("/college-gallery/list", {
                params: { media_type: "image", per_page: 20 },
            }),
            axios.get("/home/partner-colleges"),
            axios.get("/home/partner-logos"),
        ]);

        const galleryItems = galleryRes.data.data.items ?? [];
        const gallerySlides = mapGallerySlides(galleryItems);

        if (gallerySlides.length) {
            colleges.value = gallerySlides;
        } else {
            const collegeItems = collegesRes.data.data.colleges ?? [];
            const logos = logosRes.data.data.logos ?? [];
            colleges.value = mergeCollegeSlides(collegeItems, logos);
        }

        resetProgress();
        startRotation();
    } catch (error) {
        console.error("Error fetching partner colleges:", error);
    } finally {
        loading.value = false;
    }
});

onBeforeUnmount(() => {
    stopRotation();
});
</script>
