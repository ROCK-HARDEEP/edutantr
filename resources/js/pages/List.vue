<template>
    <section class="py-4" style="background: #F1F5F9;">
        <section class="container">
            <div class="row">
                <div class="col-12 d-block d-lg-none mb-4 mb-lg-0 d-flex justify-content-end align-items-center gap-2">
                    <span class="text-muted fs-6">{{ $t('Filtering') }}: </span>
                    <button type="button" class="btn btn-sm px-3 py-2 fs-5 fw-bold" :class="filterToggle
                        ? 'btn-outline-primary'
                        : 'border-2 border-primary'
                        " @click="filterToggle = !filterToggle">
                        <i :class="filterToggle
                            ? 'bi bi-funnel-fill'
                            : 'text-primary bi bi-funnel'
                            "></i>
                    </button>
                </div>
                <!-- Filters (single instance — avoids duplicate API calls) -->
                <div
                    class="col-12 col-lg-3 mb-4 mb-lg-0"
                    :class="filterToggle ? 'd-block' : 'd-none d-lg-block'"
                >
                    <div class="bg-white rounded-2 overflow-hidden p-2 filters-panel">
                        <div
                            class="d-flex justify-content-between align-items-center border-bottom border-light px-3 py-4"
                        >
                            <h5 class="fw-bold fs-3 mb-0 d-none d-lg-block">{{ $t('Filters') }}</h5>
                            <h5 class="fw-bold mb-0 d-lg-none">{{ $t('Filters') }}</h5>
                            <span @click="applyReset" class="text-decoration-none cursor-pointer text-danger">
                                {{ $t('Reset') }}
                            </span>
                        </div>
                        <div class="input-group my-2 px-2 d-none d-lg-flex" role="search">
                            <span
                                class="input-group-text bg-light border-0 border-start border-top border-bottom px-3 py-2"
                                id="basic-addon1"
                            >
                                <i class="ri ri-search-line"></i>
                            </span>
                            <input
                                v-model="filterQuery"
                                class="form-control search-input border-0 border-top border-bottom border-end bg-light ps-0 py-2"
                                type="search"
                                :placeholder="$t('Search Filters data here')"
                            />
                        </div>

                        <div class="filters-scroll">
                            <div class="px-3 py-1 border-bottom">
                                <CategoryFilter @categoryFilter="applyCatFilter" />
                            </div>
                            <div class="px-3 py-1 border-bottom">
                                <SortOptions @sort="applySort" />
                            </div>
                            <div class="px-3 py-1 border-bottom">
                                <InstructorFilter @instructorFilter="applyInstFilter" />
                            </div>
                            <div class="px-3 py-1">
                                <RatingFilter @RatingFilter="applyRatingFilter" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-9">
                    <h1 v-if="search" class="fw-bold text-center mb-5">
                        <span class="text-muted">{{ $t('Search') }} -</span> {{ search }}
                    </h1>
                    <h1 v-if="category_id" class="fw-bold text-center mb-5">
                        <span class="text-muted">{{ $t('Category') }} -</span>
                        {{ categoryTitle }}
                    </h1>
                    <section class="row align-items-center p-3 rounded-2 bg-white mb-4">
                        <div class="col-12 col-lg-6 text-center mb-3 mb-lg-0 text-lg-start">
                            <span v-if="loading" class="courses-count courses-count--loading">
                                <span class="courses-count-dot"></span>
                                {{ $t('Loading courses...') }}
                            </span>
                            <span v-else>
                                {{ $t('Showing') }} {{ courses.length }} of
                                {{ totalItems }} {{ $t('courses') }}
                            </span>
                        </div>

                        <div class="col-12 col-lg-6">
                            <form @submit.prevent="performSearch" class="input-group border rounded-pill" role="search">
                                <input v-model="searchInputQuery"
                                    class="form-control border-0 rounded-pill search-input" type="search"
                                    :placeholder="$t('Search Course')" @input="
                                        searchInputQuery === ''
                                            ? applyReset()
                                            : null
                                        " />
                                <button type="submit" class="btn btn-primary d-flex rounded-pill px-4">
                                    <img :src="'/assets/images/website/search.svg'" alt="Search" />
                                </button>
                            </form>
                        </div>
                    </section>
                    <div v-if="loading" class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">
                        <div v-for="n in 6" :key="n" class="mb-4">
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

                    <div v-else-if="courses.length > 0" class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">
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
                        <VueAwesomePaginate v-model="currentPage" :total-items="totalItems"
                            :items-per-page="itemsPerPage" :max-pages-shown="5" @click="onClickHandler" />
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import CategoryFilter from "../components/CategoryFilter.vue";
import RatingFilter from "../components/RatingFilter.vue";
import InstructorFilter from "../components/InstructorFilter.vue";
import SortOptions from "../components/SortOptions.vue";
import { VueAwesomePaginate } from "vue-awesome-paginate";
import CourseCard from "../components/CourseCard.vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
let filterToggle = ref(false);

const search = ref(route.query.search);
const category_id = ref(route.query.category_id);
const searchInputQuery = ref("");

let categoryTitle = ref("");

let courses = ref([]);
let loading = ref(true);
let currentPage = ref(1);
let itemsPerPage = ref(15);
let totalItems = ref(0);
let filterQuery = ref("");

const onClickHandler = (page) => {
    fetchCourses(page);
};

let params = {
    items_per_page: 10,
    page_number: 1,
    sort: "view_count",
    sortDirection: "desc",
};

function applyCatFilter(filterCat) {
    if (filterCat.length === 0) {
        params = {
            items_per_page: 12,
            page_number: 1,
            sort: "view_count",
            sortDirection: "desc",
        };
        router.push("/courses");
        fetchCourses();
    } else {
        params.category_id = filterCat;
        fetchCourses();
    }
}

function applyRatingFilter(filterRat) {
    params.average_rating = filterRat;
    fetchCourses();
}

function applyInstFilter(filterInst) {
    if (filterInst.length === 0) {
        params = {
            items_per_page: 12,
            page_number: 1,
            sort: "view_count",
            sortDirection: "desc",
        };
        router.push("/courses");
        fetchCourses();
    } else {
        params.instructor_id = filterInst;
        fetchCourses();
    }
}

function applySort(property, order) {
    params.sort = property;
    params.sortDirection = order;
    fetchCourses();
}

function applyReset() {
    search.value = null;
    params = {
        items_per_page: 12,
        page_number: 1,
        sort: "view_count",
        sortDirection: "desc",
    };
    fetchCourses();

    const radioInputs = document.querySelectorAll('input[type="radio"]');
    radioInputs.forEach((input) => {
        input.checked = false;
    });

    const checkboxInputs = document.querySelectorAll('input[type="checkbox"]');
    checkboxInputs.forEach((input) => {
        input.checked = false;
    });
    location.reload();
}

onMounted(() => {
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

// Fetch courses
async function fetchCourses(pageNumber = 1) {
    loading.value = true;

    if (search.value) {
        params["search"] = search.value;
    }

    if (category_id.value) {
        params["category_id"] = category_id.value;
    }

    params["items_per_page"] = itemsPerPage.value;
    params["page_number"] = pageNumber;

    const headers = {
        "Content-Type": "application/json",
        Accept: "application/json",
    };

    if (authStore?.authToken) {
        headers.Authorization = `Bearer ${authStore.authToken}`;
    }

    try {
        const res = await axios.get(`/course/list`, { headers, params });
        courses.value = res.data.data.courses ?? [];
        totalItems.value = res.data.data.total_courses ?? 0;
        categoryTitle.value = res.data.data.courses?.[0]?.category || "";
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

watch(
    () => filterQuery.value,
    () => {
        searchFilter();
    }
);

function searchFilter() {
    const filterValue = filterQuery.value.toLowerCase().trim();
    const items = document.querySelectorAll('.filter-item');
    const mainItems = document.querySelectorAll('.main-item');

    items.forEach(item => {
        const isVisible = item.textContent.toLowerCase().includes(filterValue);
        item.classList.toggle('d-block', isVisible);
        item.classList.toggle('d-none', !isVisible);
    });

    mainItems.forEach(mainItem => {
        const visibleChildren = [...mainItem.children].some(child => child.classList.contains('d-block'));
        mainItem.classList.toggle('d-block', visibleChildren);
        mainItem.classList.toggle('d-none', !visibleChildren);
    });
}


</script>

<style lang="scss">
.filter-list {
    height: 110px;
    overflow-y: scroll;
}

.filters-panel {
    position: sticky;
    top: 100px;
}

.filters-scroll {
    overflow-y: auto;
    max-height: calc(100vh - 245px);
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
