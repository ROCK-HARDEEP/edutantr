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

        <div class="category-tabs d-flex justify-content-center flex-wrap gap-2 mb-5">
            <button
                @click="categoryId = null"
                :class="['category-tab', categoryId == null ? 'category-tab--active' : '']"
            >
                <i v-if="categoryId == null" class="bi bi-check-lg category-tab__check" aria-hidden="true"></i>
                <i v-else class="bi bi-grid-3x3-gap-fill category-tab__icon" aria-hidden="true"></i>
                {{ $t('All') }}
            </button>

            <button
                v-for="category in featuredCategories"
                :key="category.id"
                @click="categoryId = category.id; pageNumber = 1;"
                :class="['category-tab', category.id == categoryId ? 'category-tab--active' : '']"
            >
                <i v-if="category.id == categoryId" class="bi bi-check-lg category-tab__check" aria-hidden="true"></i>
                <img
                    v-else-if="category.image"
                    :src="category.image"
                    :alt="category.title"
                    class="category-tab__img"
                />
                <i v-else class="bi bi-bookmark-fill category-tab__icon" aria-hidden="true"></i>
                {{ category.title }}
            </button>
        </div>

        <div class="row g-4">
            <div v-for="course in popularCourses" :key="course.id" class="col-12 col-md-6 col-lg-4 col-xl-3">
                <CourseCard :course="course" variant="popular" class="course-card-premium" />
            </div>
        </div>

        <div v-if="popularCourses.length == 0" class="empty-state text-center my-5">
            <i class="bi bi-journal-x text-muted display-1 mb-3 d-block"></i>
            <h4 class="fw-semibold text-muted">{{ $t('No courses found') }}</h4>
        </div>

        <div v-if="totalCourses > popularCourses.length" class="text-center">
            <button @click="loadMore" class="btn load-more-btn mt-5 px-5 fw-bold">
                {{ $t('Load More') }}
                <i class="bi bi-arrow-down-circle ms-2"></i>
            </button>
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

.category-tabs {
    max-width: 100%;
    overflow-x: auto;
    flex-wrap: nowrap;
    justify-content: flex-start !important;
    padding-bottom: 0.25rem;

    @media (min-width: 768px) {
        flex-wrap: wrap;
        justify-content: center !important;
        overflow-x: visible;
    }
}

.category-tabs::-webkit-scrollbar {
    display: none;
}

.category-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.6rem 1.15rem;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
    background: #fff;
    color: #374151;
    font-size: 0.84rem;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.25s ease;
    cursor: pointer;
    box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);

    &:hover:not(.category-tab--active) {
        background: #fafafa;
        border-color: #e5e7eb;
    }
}

.category-tab--active {
    background: #ffedd5;
    border-color: #fed7aa;
    color: #9a3412;
    box-shadow: 0 2px 8px rgba(249, 115, 22, 0.12);
}

.category-tab__check {
    font-size: 0.95rem;
    color: #ea580c;
    font-weight: 700;
}

.category-tab__icon {
    font-size: 0.95rem;
    color: #9ca3af;
}

.category-tab__img {
    width: 20px;
    height: 20px;
    object-fit: contain;
    border-radius: 4px;
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

.load-more-btn {
    background: #f97316;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 0.85rem 2.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.28);

    &:hover {
        background: #ea580c;
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(249, 115, 22, 0.38);
        color: #fff;
    }
}
</style>

<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import CourseCard from "./CourseCard.vue";

const categoryId = ref(null);
const pageNumber = ref(1);
const itemsPerPage = ref(8);
const popularCourses = ref([]);
const totalCourses = ref(0);
const featuredCategories = ref([]);

const fetchPopularCourses = async () => {
    try {
        const params = {
            items_per_page: itemsPerPage.value,
            page_number: pageNumber.value,
            sort: "view_count",
            sortDirection: "desc",
        };

        if (categoryId.value) {
            params.category_id = categoryId.value;
        }

        const response = await axios.get(`/course/list`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params,
        });

        const courses = response.data.data.courses ?? [];

        if (pageNumber.value === 1) {
            popularCourses.value = courses;
        } else {
            popularCourses.value = [...popularCourses.value, ...courses];
        }
        totalCourses.value = response.data.data.total_courses ?? 0;
    } catch (error) {
        console.error("Error fetching courses:", error);
    }
};

const fetchFeaturedCategories = async () => {
    try {
        const response = await axios.get(`/categories`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                is_featured: true,
                items_per_page: 20,
                page_number: 1,
            },
        });
        featuredCategories.value = response.data.data.categories;
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
};

const loadMore = () => {
    pageNumber.value++;
    fetchPopularCourses();
};

watch(categoryId, () => {
    fetchPopularCourses();
});

onMounted(() => {
    fetchFeaturedCategories();
    fetchPopularCourses();
});
</script>
