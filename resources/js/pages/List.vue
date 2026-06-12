<template>
    <section class="py-4" style="background: #F1F5F9;">
        <section class="container">
            <h1 v-if="search" class="fw-bold text-center mb-4">
                <span class="text-muted">{{ $t('Search') }} -</span> {{ search }}
            </h1>

            <section class="courses-toolbar rounded-2 bg-white mb-4">
                <div class="row align-items-center p-3 pb-0">
                    <div class="col-12 col-lg-5 text-center mb-3 mb-lg-0 text-lg-start">
                        <span v-if="loading" class="courses-count courses-count--loading">
                            <span class="courses-count-dot"></span>
                            {{ $t('Loading courses...') }}
                        </span>
                        <span v-else class="courses-count-label">
                            {{ $t('Showing') }} {{ courses.length }} {{ $t('of') }}
                            {{ totalItems }} {{ $t('courses') }}
                        </span>
                    </div>

                    <div class="col-12 col-lg-7">
                        <form @submit.prevent="performSearch" class="input-group border rounded-pill" role="search">
                            <input
                                v-model="searchInputQuery"
                                class="form-control border-0 rounded-pill search-input"
                                type="search"
                                :placeholder="$t('Search Course')"
                                @input="searchInputQuery === '' ? clearSearch() : null"
                            />
                            <button type="submit" class="btn btn-primary d-flex rounded-pill px-4">
                                <img :src="'/assets/images/website/search.svg'" alt="Search" />
                            </button>
                        </form>
                    </div>
                </div>

                <div v-if="categories.length" class="category-tabs-wrap px-3 pb-3">
                    <div class="category-tabs">
                        <button
                            type="button"
                            :class="['category-tab', !category_id ? 'category-tab--active' : '']"
                            @click="selectCategory(null)"
                        >
                            <i v-if="!category_id" class="bi bi-check-lg category-tab__check" aria-hidden="true"></i>
                            <i v-else class="bi bi-grid-3x3-gap-fill category-tab__icon" aria-hidden="true"></i>
                            {{ $t('All') }}
                        </button>
                        <button
                            v-for="category in categories"
                            :key="category.id"
                            type="button"
                            :class="['category-tab', String(category.id) === String(category_id) ? 'category-tab--active' : '']"
                            @click="selectCategory(category.id)"
                        >
                            <i
                                v-if="String(category.id) === String(category_id)"
                                class="bi bi-check-lg category-tab__check"
                                aria-hidden="true"
                            ></i>
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
                </div>
            </section>

            <div v-if="loading" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                <div v-for="n in 8" :key="n" class="mb-4">
                    <div class="course-skeleton card border-0 h-100 overflow-hidden">
                        <div class="course-skeleton__thumb"></div>
                        <div class="card-body">
                            <div class="course-skeleton__line course-skeleton__line--sm"></div>
                            <div class="course-skeleton__line course-skeleton__line--md"></div>
                            <div class="course-skeleton__line course-skeleton__line--lg"></div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="course-skeleton__line course-skeleton__line--price"></div>
                                <div class="course-skeleton__line course-skeleton__line--btn"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="courses.length > 0" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                <div v-for="course in courses" :key="course.id" class="mb-4">
                    <CourseCard :course="course" />
                </div>
            </div>

            <div v-else class="courses-empty text-center my-5 py-5">
                <div class="courses-empty__icon">
                    <i class="bi bi-journal-x"></i>
                </div>
                <h3 class="fw-bold mb-2">{{ $t('No courses found') }}</h3>
                <p class="text-muted mb-4">{{ $t('Try adjusting your filters or search for something else.') }}</p>
                <button type="button" class="btn btn-primary rounded-pill px-4" @click="applyReset">
                    {{ $t('Clear Filters') }}
                </button>
            </div>

            <div v-if="!loading && courses.length > 0" class="text-center my-4">
                <VueAwesomePaginate
                    v-model="currentPage"
                    :total-items="totalItems"
                    :items-per-page="itemsPerPage"
                    :max-pages-shown="5"
                    @click="onClickHandler"
                />
            </div>
        </section>
    </section>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import { VueAwesomePaginate } from "vue-awesome-paginate";
import CourseCard from "../components/CourseCard.vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();

const search = ref(route.query.search);
const category_id = ref(route.query.category_id);
const searchInputQuery = ref("");

const categories = ref([]);

const courses = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const itemsPerPage = ref(15);
const totalItems = ref(0);

let params = {
    items_per_page: 15,
    page_number: 1,
    sort: "view_count",
    sortDirection: "desc",
};

const onClickHandler = (page) => {
    fetchCourses(page);
};

function applyReset() {
    search.value = null;
    category_id.value = null;
    searchInputQuery.value = "";
    params = {
        items_per_page: itemsPerPage.value,
        page_number: 1,
        sort: "view_count",
        sortDirection: "desc",
    };
    router.push("/courses");
    fetchCourses();
}

function clearSearch() {
    if (search.value) {
        search.value = null;
        searchInputQuery.value = "";
        const query = category_id.value ? { category_id: category_id.value } : {};
        router.push({ path: "/courses", query });
    }
}

function selectCategory(id) {
    search.value = null;
    searchInputQuery.value = "";
    category_id.value = id;

    if (id) {
        router.push({ path: "/courses", query: { category_id: id } });
    } else {
        router.push("/courses");
    }
}

async function fetchCategories() {
    try {
        const res = await axios.get("/categories", {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                items_per_page: 50,
                page_number: 1,
            },
        });
        categories.value = res.data.data.categories ?? [];
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
}

onMounted(() => {
    fetchCategories();
    fetchCourses();
});

watch(
    () => route.query,
    () => {
        search.value = route.query.search;
        category_id.value = route.query.category_id;
        searchInputQuery.value = route.query.search ?? "";
        fetchCourses();
    }
);

async function fetchCourses(pageNumber = 1) {
    loading.value = true;

    const requestParams = {
        ...params,
        items_per_page: itemsPerPage.value,
        page_number: pageNumber,
    };

    if (search.value) {
        requestParams.search = search.value;
    }

    if (category_id.value) {
        requestParams.category_id = category_id.value;
    }

    const headers = {
        "Content-Type": "application/json",
        Accept: "application/json",
    };

    if (authStore?.authToken) {
        headers.Authorization = `Bearer ${authStore.authToken}`;
    }

    try {
        const res = await axios.get(`/course/list`, { headers, params: requestParams });
        courses.value = res.data.data.courses ?? [];
        totalItems.value = res.data.data.total_courses ?? 0;
        currentPage.value = pageNumber;
    } catch (error) {
        console.error("Error fetching courses:", error);
        courses.value = [];
        totalItems.value = 0;
    } finally {
        loading.value = false;
    }
}

const performSearch = () => {
    if (searchInputQuery.value) {
        router.push(`/courses?search=${searchInputQuery.value}`);
    }
};
</script>

<style lang="scss">
.courses-toolbar {
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
}

.courses-count-label {
    font-weight: 500;
    color: #475569;
    white-space: nowrap;
}

.category-tabs-wrap {
    border-top: 1px solid #f1f5f9;
    padding-top: 0.85rem !important;
    margin-top: 0.75rem;
}

.category-tabs {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.15rem;
    -webkit-overflow-scrolling: touch;

    &::-webkit-scrollbar {
        height: 4px;
    }

    &::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }
}

.category-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 0.82rem;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;

    &:hover:not(.category-tab--active) {
        border-color: #bbf7d0;
        background: #f0fdf4;
        color: #15803d;
    }
}

.category-tab--active {
    background: linear-gradient(135deg, #15803d, #22c55e);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
}

.category-tab__check {
    font-size: 0.9rem;
}

.category-tab__icon {
    font-size: 0.85rem;
    color: #94a3b8;
}

.category-tab--active .category-tab__icon {
    color: #fff;
}

.category-tab__img {
    width: 18px;
    height: 18px;
    object-fit: contain;
    border-radius: 4px;
}

.courses-count--loading {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-weight: 500;
}

.courses-count-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22c55e;
    animation: courses-pulse 1s ease-in-out infinite;
}

@keyframes courses-pulse {
    0%,
    100% {
        opacity: 0.4;
        transform: scale(0.85);
    }
    50% {
        opacity: 1;
        transform: scale(1);
    }
}

.course-skeleton {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
    background: #fff;
}

.course-skeleton__thumb {
    height: 180px;
    background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
    background-size: 200% 100%;
    animation: courses-shimmer 1.4s ease-in-out infinite;
}

.course-skeleton__line {
    height: 12px;
    border-radius: 6px;
    margin-bottom: 0.65rem;
    background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
    background-size: 200% 100%;
    animation: courses-shimmer 1.4s ease-in-out infinite;

    &--sm {
        width: 45%;
    }

    &--md {
        width: 70%;
    }

    &--lg {
        width: 90%;
        height: 16px;
    }

    &--price {
        width: 35%;
        margin-bottom: 0;
    }

    &--btn {
        width: 28%;
        margin-bottom: 0;
    }
}

@keyframes courses-shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

.courses-empty__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    margin-bottom: 1.25rem;
    border-radius: 50%;
    background: linear-gradient(135deg, #dcfce7, #f0fdf4);
    color: #16a34a;
    font-size: 2rem;
}
</style>
