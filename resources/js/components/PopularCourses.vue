<template>
    <div class="popular-courses">
        <div class="popular-courses__header text-center">
            <span class="popular-courses__badge">
                <i class="bi bi-bar-chart-fill" aria-hidden="true"></i>
                {{ $t('Top Popular Course') }}
            </span>
            <h2 class="popular-courses__title">
                {{ $t('All The Skills You Need In One Place') }}
            </h2>
        </div>

        <div v-if="isLoading" class="popular-courses__slider popular-courses__slider--loading">
            <div class="popular-courses__loading-grid">
                <div v-for="index in 3" :key="index" class="popular-courses__skeleton"></div>
            </div>
        </div>

        <div v-else-if="popularCourses.length" class="popular-courses__slider">
            <swiper
                :key="swiperKey"
                :modules="[Navigation, Autoplay]"
                :slides-per-view="SLIDES_PER_VIEW"
                :slides-per-group="1"
                :space-between="28"
                :speed="900"
                :loop="true"
                :loop-fill-group-with-blank="false"
                :loop-additional-slides="SLIDES_PER_VIEW"
                :watch-slides-progress="true"
                :breakpoints="swiperBreakpoints"
                :autoplay="autoplayOptions"
                navigation
                @swiper="onSwiper"
            >
                <swiper-slide
                    v-for="(course, index) in displayCourses"
                    :key="`popular-${course.id}-${index}`"
                >
                    <CourseCard :course="course" variant="popular" class="course-card-premium" />
                </swiper-slide>
            </swiper>
        </div>

        <div v-else class="empty-state text-center my-5">
            <i class="bi bi-journal-x text-muted display-1 mb-3 d-block"></i>
            <h4 class="fw-semibold text-muted">{{ $t('No courses found') }}</h4>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.popular-courses__header {
    margin-bottom: 2rem;
}

.popular-courses__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.45rem 1rem;
    margin-bottom: 1rem;
    border-radius: 50px;
    background: #fff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    color: #6b7280;
    font-size: 0.82rem;
    font-weight: 600;

    i {
        color: #9ca3af;
        font-size: 0.9rem;
    }
}

.popular-courses__title {
    font-size: clamp(1.65rem, 3.2vw, 2.35rem);
    font-weight: 800;
    color: #111827;
    line-height: 1.25;
    letter-spacing: -0.02em;
    margin: 0;
    max-width: 720px;
    margin-left: auto;
    margin-right: auto;
}

.popular-courses__slider {
    &--loading {
        min-height: 420px;
    }
}

.popular-courses__loading-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 28px;
}

.popular-courses__skeleton {
    min-height: 380px;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
    background-size: 200% 100%;
    animation: popular-courses-shimmer 1.4s ease-in-out infinite;
}

@keyframes popular-courses-shimmer {
    0% {
        background-position: 200% 0;
    }

    100% {
        background-position: -200% 0;
    }
}

.popular-courses__slider:not(.popular-courses__slider--loading) {
    :deep(.swiper) {
        overflow: hidden;
    }

    :deep(.swiper-slide) {
        height: auto;
    }

    :deep(.swiper-button-next),
    :deep(.swiper-button-prev) {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #f97316;

        &::after {
            font-size: 0.95rem;
            font-weight: 700;
        }
    }
}

.course-card-premium {
    transition: transform 0.3s ease;

    &:hover {
        transform: translateY(-6px);
    }
}

.empty-state i {
    opacity: 0.4;
    font-size: 3.5rem;
}
</style>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Autoplay } from "swiper/modules";
import CourseCard from "./CourseCard.vue";

const popularCourses = ref([]);
const isLoading = ref(true);

const SLIDES_PER_VIEW = 3;

const autoplayOptions = {
    delay: 3500,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
};

const swiperBreakpoints = {
    320: { slidesPerView: SLIDES_PER_VIEW, slidesPerGroup: 1, spaceBetween: 16 },
    576: { slidesPerView: SLIDES_PER_VIEW, slidesPerGroup: 1, spaceBetween: 20 },
    768: { slidesPerView: SLIDES_PER_VIEW, slidesPerGroup: 1, spaceBetween: 24 },
    992: { slidesPerView: SLIDES_PER_VIEW, slidesPerGroup: 1, spaceBetween: 28 },
};

const displayCourses = computed(() => {
    const courses = popularCourses.value;
    if (!courses.length) {
        return [];
    }

    const minForLoop = Math.max(SLIDES_PER_VIEW * 4, 12);
    const result = [...courses];

    while (result.length < minForLoop) {
        result.push(...courses);
    }

    return result;
});

const swiperKey = computed(() => `${popularCourses.value.length}-${displayCourses.value.length}`);

const onSwiper = (swiper) => {
    if (swiper?.autoplay) {
        swiper.autoplay.start();
    }
};

const fetchPopularCourses = async () => {
    try {
        const response = await axios.get(`/course/list`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                items_per_page: 12,
                page_number: 1,
                sort: "view_count",
                sortDirection: "desc",
            },
        });

        popularCourses.value = response.data.data.courses ?? [];
    } catch (error) {
        console.error("Error fetching courses:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchPopularCourses();
});
</script>
