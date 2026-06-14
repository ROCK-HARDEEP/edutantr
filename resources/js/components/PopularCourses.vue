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
                :modules="[Navigation, Autoplay, Pagination]"
                :slides-per-view="1"
                :slides-per-group="1"
                :space-between="16"
                :speed="900"
                :loop="popularCourses.length > 1"
                :loop-fill-group-with-blank="false"
                :loop-additional-slides="3"
                :watch-slides-progress="true"
                :breakpoints="swiperBreakpoints"
                :autoplay="autoplayOptions"
                navigation
                pagination
                class="popular-courses__swiper"
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
.popular-courses {
    width: 100%;
    overflow: hidden;
}

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
        padding-bottom: 2.75rem;
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
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);

        &::after {
            font-size: 0.95rem;
            font-weight: 700;
        }
    }

    :deep(.swiper-pagination) {
        bottom: 0 !important;
    }

    :deep(.swiper-pagination-bullet) {
        width: 8px;
        height: 8px;
        background: #cbd5e1;
        opacity: 1;
        transition: width 0.25s ease, background 0.25s ease;
    }

    :deep(.swiper-pagination-bullet-active) {
        width: 22px;
        border-radius: 4px;
        background: #f97316;
    }
}

@media (max-width: 991px) {
    .popular-courses__header {
        margin-bottom: 1.5rem;
    }

    .popular-courses__slider--loading {
        min-height: 340px;
    }

    .popular-courses__loading-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }
}

@media (max-width: 767px) {
    .popular-courses__header {
        margin-bottom: 1.25rem;
        padding-inline: 0.25rem;
    }

    .popular-courses__badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.85rem;
        margin-bottom: 0.75rem;
    }

    .popular-courses__title {
        font-size: clamp(1.25rem, 5.5vw, 1.65rem);
        line-height: 1.3;
        padding-inline: 0.35rem;
    }

    .popular-courses__slider--loading {
        min-height: 300px;
    }

    .popular-courses__loading-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .popular-courses__skeleton {
        min-height: 280px;
    }

    .popular-courses__slider:not(.popular-courses__slider--loading) {
        :deep(.swiper) {
            padding-bottom: 2.25rem;
        }

        :deep(.swiper-button-next),
        :deep(.swiper-button-prev) {
            width: 36px;
            height: 36px;
            top: 38%;

            &::after {
                font-size: 0.8rem;
            }
        }

        :deep(.swiper-button-prev) {
            left: 2px;
        }

        :deep(.swiper-button-next) {
            right: 2px;
        }
    }

    .course-card-premium:hover {
        transform: none;
    }
}

@media (max-width: 575px) {
    .popular-courses__slider:not(.popular-courses__slider--loading) {
        :deep(.swiper-button-next),
        :deep(.swiper-button-prev) {
            display: none;
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
import { Navigation, Autoplay, Pagination } from "swiper/modules";
import CourseCard from "./CourseCard.vue";

const popularCourses = ref([]);
const isLoading = ref(true);

const MAX_SLIDES_PER_VIEW = 3;

const autoplayOptions = {
    delay: 3500,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
};

const swiperBreakpoints = {
    480: {
        slidesPerView: 1.08,
        spaceBetween: 14,
    },
    640: {
        slidesPerView: 1.15,
        spaceBetween: 16,
    },
    768: {
        slidesPerView: 2,
        spaceBetween: 20,
    },
    992: {
        slidesPerView: MAX_SLIDES_PER_VIEW,
        spaceBetween: 28,
    },
};

const displayCourses = computed(() => {
    const courses = popularCourses.value;
    if (!courses.length) {
        return [];
    }

    const minForLoop = Math.max(MAX_SLIDES_PER_VIEW * 4, 12);
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
