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

        <div v-if="popularCourses.length" class="popular-courses__slider">
            <swiper
                :modules="[Navigation, Pagination, Autoplay]"
                :space-between="20"
                :breakpoints="swiperBreakpoints"
                navigation
                pagination
                autoplay
                loop
            >
                <swiper-slide v-for="course in popularCourses" :key="course.id" class="pb-4">
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

    :deep(.swiper-pagination-bullet-active) {
        background: #f97316;
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
import { ref, onMounted } from "vue";
import axios from "axios";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import CourseCard from "./CourseCard.vue";

const popularCourses = ref([]);

const swiperBreakpoints = {
    320: { slidesPerView: 1.15, spaceBetween: 16 },
    576: { slidesPerView: 2, spaceBetween: 18 },
    768: { slidesPerView: 2.5, spaceBetween: 20 },
    992: { slidesPerView: 3, spaceBetween: 22 },
    1200: { slidesPerView: 4, spaceBetween: 24 },
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
    }
};

onMounted(() => {
    fetchPopularCourses();
});
</script>
