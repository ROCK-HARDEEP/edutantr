<template>
    <section class="bg-slate-50 min-h-screen py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search result heading -->
            <h1
                v-if="search"
                class="text-2xl sm:text-3xl font-bold text-center mb-6 text-slate-800"
            >
                <span class="text-slate-400">{{ $t('Search') }} -</span>
                {{ search }}
            </h1>

            <!-- Toolbar -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm mb-6 overflow-hidden">
                <!-- Top row: count + search -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 sm:p-5 pb-0 sm:pb-0">
                    <!-- Course count -->
                    <div class="text-center sm:text-left">
                        <span
                            v-if="loading"
                            class="inline-flex items-center gap-2 text-sm font-medium text-slate-500"
                        >
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            {{ $t('Loading courses...') }}
                        </span>
                        <span v-else class="text-sm font-medium text-slate-500">
                            {{ $t('Showing') }}
                            <span class="text-slate-800">{{ courses.length }}</span>
                            {{ $t('of') }}
                            <span class="text-slate-800">{{ totalItems }}</span>
                            {{ $t('courses') }}
                        </span>
                    </div>

                    <!-- Search form -->
                    <form
                        @submit.prevent="performSearch"
                        class="w-full sm:w-auto sm:min-w-[320px]"
                        role="search"
                    >
                        <div class="relative flex items-center">
                            <input
                                v-model="searchInputQuery"
                                type="search"
                                :placeholder="$t('Search Course')"
                                @input="searchInputQuery === '' ? clearSearch() : null"
                                class="w-full rounded-full border border-slate-200 bg-slate-50 pl-5 pr-14 py-2.5 text-sm text-slate-700 placeholder-slate-400 outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition-all"
                            />
                            <button
                                type="submit"
                                class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-green-600 hover:bg-green-700 text-white flex items-center justify-center transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Category tabs -->
                <div
                    v-if="categories.length"
                    class="border-t border-slate-100 px-4 sm:px-5 pt-3 pb-3"
                >
                    <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-thin">
                        <!-- All tab -->
                        <button
                            type="button"
                            :class="[
                                'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap border transition-all duration-200 shrink-0',
                                !category_id
                                    ? 'bg-gradient-to-r from-green-600 to-green-500 border-transparent text-white shadow-md shadow-green-500/25'
                                    : 'bg-white border-slate-200 text-slate-500 hover:border-green-200 hover:bg-green-50 hover:text-green-700'
                            ]"
                            @click="selectCategory(null)"
                        >
                            <svg v-if="category_id" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" :class="category_id ? 'text-white' : 'text-slate-400'" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                            </svg>
                            {{ $t('All') }}
                        </button>

                        <!-- Category tabs -->
                        <button
                            v-for="category in categories"
                            :key="category.id"
                            type="button"
                            :class="[
                                'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap border transition-all duration-200 shrink-0',
                                String(category.id) === String(category_id)
                                    ? 'bg-gradient-to-r from-green-600 to-green-500 border-transparent text-white shadow-md shadow-green-500/25'
                                    : 'bg-white border-slate-200 text-slate-500 hover:border-green-200 hover:bg-green-50 hover:text-green-700'
                            ]"
                            @click="selectCategory(category.id)"
                        >
                            <svg v-if="String(category.id) === String(category_id)" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            <img
                                v-else-if="category.image"
                                :src="category.image"
                                :alt="category.title"
                                class="w-[18px] h-[18px] object-contain rounded"
                            />
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
                            </svg>
                            {{ category.title }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading skeleton grid -->
            <div
                v-if="loading"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            >
                <div v-for="n in 8" :key="n" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="h-44 bg-gradient-to-r from-slate-200 via-slate-100 to-slate-200 animate-pulse bg-[length:200%_100%]"></div>
                    <div class="p-4 space-y-3">
                        <div class="h-3 bg-slate-200 rounded-full w-2/5 animate-pulse"></div>
                        <div class="h-4 bg-slate-200 rounded-full w-3/4 animate-pulse"></div>
                        <div class="h-4 bg-slate-200 rounded-full w-full animate-pulse"></div>
                        <div class="flex justify-between items-center pt-2">
                            <div class="h-3 bg-slate-200 rounded-full w-1/4 animate-pulse"></div>
                            <div class="h-8 bg-slate-200 rounded-full w-1/5 animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course cards grid -->
            <div
                v-else-if="courses.length > 0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            >
                <div v-for="course in courses" :key="course.id">
                    <CourseCard :course="course" />
                </div>
            </div>

            <!-- Empty state -->
            <div
                v-else
                class="text-center my-12 py-12"
            >
                <div class="inline-flex items-center justify-center w-20 h-20 mb-5 rounded-full bg-gradient-to-br from-green-100 to-green-50 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $t('No courses found') }}</h3>
                <p class="text-slate-400 mb-6">{{ $t('Try adjusting your filters or search for something else.') }}</p>
                <button
                    type="button"
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-full transition-colors shadow-md shadow-green-600/20"
                    @click="applyReset"
                >
                    {{ $t('Clear Filters') }}
                </button>
            </div>

            <!-- Pagination -->
            <div v-if="!loading && courses.length > 0" class="text-center my-6">
                <VueAwesomePaginate
                    v-model="currentPage"
                    :total-items="totalItems"
                    :items-per-page="itemsPerPage"
                    :max-pages-shown="5"
                    @click="onClickHandler"
                />
            </div>
        </div>
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

const fallbackCourses = [
    { id: 1, title: "Full Stack Web Development", category: "Technology", thumbnail: "", price: "15000", regular_price: "25000", average_rating: "4.8", review_count: "120", chapter_count: 24, total_duration: 720, instructor: { id: 1, name: "Rajesh Kumar", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["React", "Node.js", "MongoDB", "AWS"] },
    { id: 2, title: "Artificial Intelligence with Machine Learning", category: "Technology", thumbnail: "", price: "18000", regular_price: "30000", average_rating: "4.9", review_count: "95", chapter_count: 28, total_duration: 840, instructor: { id: 2, name: "Priya Venkatesh", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Intermediate", tech_stacks: ["Python", "TensorFlow", "PyTorch"] },
    { id: 3, title: "Data Science", category: "Data & Analytics", thumbnail: "", price: "12000", regular_price: "20000", average_rating: "4.7", review_count: "88", chapter_count: 20, total_duration: 600, instructor: { id: 3, name: "Arun Prasad", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Python", "SQL", "Power BI"] },
    { id: 4, title: "DevOps", category: "Technology", thumbnail: "", price: "14000", regular_price: "22000", average_rating: "4.6", review_count: "65", chapter_count: 22, total_duration: 660, instructor: { id: 1, name: "Rajesh Kumar", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Intermediate", tech_stacks: ["Docker", "Kubernetes", "Jenkins"] },
    { id: 5, title: "Software Testing", category: "Technology", thumbnail: "", price: "10000", regular_price: "18000", average_rating: "4.5", review_count: "55", chapter_count: 18, total_duration: 540, instructor: { id: 4, name: "Deepa Lakshmi", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Selenium", "JIRA", "TestNG"] },
    { id: 6, title: "Python with Power BI", category: "Data & Analytics", thumbnail: "", price: "11000", regular_price: "19000", average_rating: "4.7", review_count: "72", chapter_count: 20, total_duration: 600, instructor: { id: 2, name: "Priya Venkatesh", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Python", "Power BI", "Pandas"] },
    { id: 7, title: "Application Development", category: "Technology", thumbnail: "", price: "15000", regular_price: "25000", average_rating: "4.6", review_count: "48", chapter_count: 24, total_duration: 720, instructor: { id: 1, name: "Rajesh Kumar", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Intermediate", tech_stacks: ["React Native", "Flutter", "Firebase"] },
    { id: 8, title: "Data Analytics / Business Analytics", category: "Data & Analytics", thumbnail: "", price: "10000", regular_price: "18000", average_rating: "4.5", review_count: "42", chapter_count: 18, total_duration: 540, instructor: { id: 2, name: "Priya Venkatesh", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Excel", "SQL", "Power BI"] },
    { id: 9, title: "Cyber Security", category: "Technology", thumbnail: "", price: "16000", regular_price: "28000", average_rating: "4.8", review_count: "58", chapter_count: 26, total_duration: 780, instructor: { id: 3, name: "Arun Prasad", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Intermediate", tech_stacks: ["Ethical Hacking", "Network Security", "SIEM"] },
    { id: 10, title: "Embedded Systems", category: "Hardware", thumbnail: "", price: "12000", regular_price: "20000", average_rating: "4.4", review_count: "35", chapter_count: 20, total_duration: 600, instructor: { id: 3, name: "Arun Prasad", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Intermediate", tech_stacks: ["C", "C++", "Arduino"] },
    { id: 11, title: "VLSI", category: "Hardware", thumbnail: "", price: "14000", regular_price: "24000", average_rating: "4.5", review_count: "30", chapter_count: 24, total_duration: 720, instructor: { id: 3, name: "Arun Prasad", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Advanced", tech_stacks: ["Verilog", "VHDL", "Cadence"] },
    { id: 12, title: "Digital Marketing", category: "Business", thumbnail: "", price: "8000", regular_price: "15000", average_rating: "4.6", review_count: "65", chapter_count: 16, total_duration: 480, instructor: { id: 4, name: "Deepa Lakshmi", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["SEO", "Google Ads", "Social Media"] },
    { id: 13, title: "Business Growth Specialist", category: "Business", thumbnail: "", price: "12000", regular_price: "20000", average_rating: "4.8", review_count: "40", chapter_count: 18, total_duration: 540, instructor: { id: 1, name: "Rajesh Kumar", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Strategy", "Sales", "Marketing"] },
    { id: 14, title: "Human Resource Management", category: "Business", thumbnail: "", price: "8000", regular_price: "14000", average_rating: "4.4", review_count: "28", chapter_count: 16, total_duration: 480, instructor: { id: 4, name: "Deepa Lakshmi", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["HRIS", "Recruitment", "Payroll"] },
    { id: 15, title: "Cloud Computing", category: "Technology", thumbnail: "", price: "16000", regular_price: "28000", average_rating: "4.8", review_count: "52", chapter_count: 26, total_duration: 780, instructor: { id: 3, name: "Arun Prasad", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Intermediate", tech_stacks: ["AWS", "Azure", "GCP"] },
    { id: 16, title: "UI/UX", category: "Technology", thumbnail: "", price: "10000", regular_price: "18000", average_rating: "4.7", review_count: "45", chapter_count: 18, total_duration: 540, instructor: { id: 4, name: "Deepa Lakshmi", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Figma", "Adobe XD", "Prototyping"] },
    { id: 17, title: "Finance & Tally", category: "Business", thumbnail: "", price: "7000", regular_price: "12000", average_rating: "4.3", review_count: "32", chapter_count: 14, total_duration: 420, instructor: { id: 2, name: "Priya Venkatesh", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["Tally", "GST", "Income Tax"] },
    { id: 18, title: "Medical Coding", category: "Technology", thumbnail: "", price: "9000", regular_price: "16000", average_rating: "4.5", review_count: "38", chapter_count: 16, total_duration: 480, instructor: { id: 4, name: "Deepa Lakshmi", profile_picture: "" }, is_free: false, is_enrolled: false, difficulty_level: "Beginner", tech_stacks: ["ICD-10", "CPT", "HIPAA"] },
];

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
        // If API returns empty, show fallback programs
        if (courses.value.length === 0 && !search.value && !category_id.value) {
            courses.value = fallbackCourses;
            totalItems.value = fallbackCourses.length;
        }
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

<style scoped>
/* Thin scrollbar for category tabs */
.scrollbar-thin::-webkit-scrollbar {
    height: 4px;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 999px;
}
</style>
