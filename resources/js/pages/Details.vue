<template>
    <section
        class="min-h-screen"
        :style="{ backgroundImage: 'url(/assets/images/website/details-bg.png)', backgroundRepeat: 'no-repeat', backgroundSize: 'contain' }"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 sm:pt-28 pb-10">
            <div class="bg-slate-50 rounded-2xl p-3 sm:p-4 lg:p-6">
                <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
                    <!-- Main content area (left) -->
                    <div class="w-full lg:w-2/3">
                        <div class="bg-white rounded-2xl p-4 sm:p-6">
                            <!-- Course metadata -->
                            <CourseMetadata :course="courseData.course" />

                            <!-- PrimeVue TabView -->
                            <TabView v-model:activeIndex="activeTab" class="course-detail-tabs mt-6">
                                <TabPanel>
                                    <template #header>
                                        <span class="flex items-center gap-2 text-sm font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                            </svg>
                                            {{ $t('About') }}
                                        </span>
                                    </template>
                                    <div class="rounded-xl bg-slate-50 p-4 sm:p-5">
                                        <CourseAbout :descriptions="courseData.description" />
                                    </div>
                                </TabPanel>

                                <TabPanel>
                                    <template #header>
                                        <span class="flex items-center gap-2 text-sm font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                                            </svg>
                                            {{ $t('Lessons') }}
                                        </span>
                                    </template>
                                    <div class="rounded-xl bg-slate-50 p-4 sm:p-5">
                                        <CourseLessons
                                            :chapters="courseData?.chapters"
                                            :courseId="courseData?.course?.id"
                                            :course="courseData?.course"
                                        />
                                    </div>
                                </TabPanel>

                                <TabPanel v-if="hasProject">
                                    <template #header>
                                        <span class="flex items-center gap-2 text-sm font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                            </svg>
                                            {{ $t('Project') }}
                                        </span>
                                    </template>
                                    <div class="rounded-xl bg-slate-50 p-4 sm:p-5">
                                        <CourseProject :project="courseData?.project" />
                                    </div>
                                </TabPanel>

                                <TabPanel>
                                    <template #header>
                                        <span class="flex items-center gap-2 text-sm font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                            {{ $t('Reviews') }}
                                        </span>
                                    </template>
                                    <div class="rounded-xl bg-slate-50 p-4 sm:p-5">
                                        <CourseReviews :courseData="courseData" />
                                    </div>
                                </TabPanel>
                            </TabView>
                        </div>
                    </div>

                    <!-- Sidebar (right) -->
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-2xl p-4 sm:p-6 lg:sticky lg:top-28">
                            <CoursePreview :course="courseData.course" :chapters="courseData.chapters" />
                        </div>

                        <!-- Technologies You'll Learn -->
                        <div v-if="technologies.length" class="bg-white rounded-2xl p-4 sm:p-6 mt-4">
                            <h3 class="text-lg font-bold text-navy mb-4 flex items-center gap-2">
                                <i class="bi bi-cpu text-primary-600"></i>
                                {{ $t("Technologies You'll Learn") }}
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="tech in technologies"
                                    :key="tech"
                                    class="px-3 py-1.5 rounded-lg bg-tech-blue/10 text-tech-blue text-sm font-semibold border border-tech-blue/20"
                                >
                                    {{ tech }}
                                </span>
                            </div>
                        </div>

                        <!-- Upcoming Batches -->
                        <div v-if="upcomingBatches.length" class="bg-white rounded-2xl p-4 sm:p-6 mt-4">
                            <h3 class="text-lg font-bold text-navy mb-4 flex items-center gap-2">
                                <i class="bi bi-calendar-event text-primary-600"></i>
                                {{ $t("Upcoming Batches") }}
                            </h3>
                            <div class="space-y-3">
                                <div
                                    v-for="batch in upcomingBatches"
                                    :key="batch.date"
                                    class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100"
                                >
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
                                            <i class="bi bi-calendar3 text-primary-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-navy">{{ batch.date }}</p>
                                            <p class="text-xs text-slate-500">{{ batch.time }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold"
                                        :class="batch.seats > 0
                                            ? 'bg-green-50 text-green-700'
                                            : 'bg-red-50 text-red-600'"
                                    >
                                        {{ batch.seats > 0 ? batch.seats + " seats left" : "Full" }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Career Outcomes -->
                        <div v-if="careerOutcomes.length" class="bg-white rounded-2xl p-4 sm:p-6 mt-4">
                            <h3 class="text-lg font-bold text-navy mb-4 flex items-center gap-2">
                                <i class="bi bi-graph-up-arrow text-primary-600"></i>
                                {{ $t("Career Outcomes") }}
                            </h3>
                            <div class="space-y-3">
                                <div
                                    v-for="outcome in careerOutcomes"
                                    :key="outcome.role"
                                    class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100"
                                >
                                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                                        <i class="bi bi-briefcase text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-navy">{{ outcome.role }}</p>
                                        <p class="text-xs text-slate-500">{{ outcome.salary }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import CourseAbout from "../components/CourseAbout.vue";
import CourseLessons from "../components/CourseLessons.vue";
import CourseProject from "../components/CourseProject.vue";
import CourseMetadata from "../components/CourseMetadata.vue";
import CoursePreview from "../components/CoursePreview.vue";
import CourseReviews from "../components/CourseReviews.vue";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";

const authStore = useAuthStore();
const route = useRoute();
const course_id = route.params.id;

const courseData = ref({});
const activeTab = ref(0);

const hasProject = computed(() => {
    const project = courseData.value?.project;

    if (!project) {
        return false;
    }

    const plainDescription = project.description?.replace(/<[^>]*>/g, "").trim() ?? "";

    return Boolean(project.title || plainDescription || project.pdf_url);
});

// Technologies You'll Learn - from course data or defaults
const technologies = computed(() => {
    if (courseData.value?.course?.tech_stacks?.length) {
        return courseData.value.course.tech_stacks;
    }
    // Fallback defaults based on course category
    const category = courseData.value?.course?.category?.toLowerCase() || "";
    if (category.includes("full-stack") || category.includes("web")) {
        return ["HTML5", "CSS3", "JavaScript", "React", "Node.js", "MongoDB", "Git"];
    }
    if (category.includes("data") || category.includes("ai")) {
        return ["Python", "Pandas", "NumPy", "TensorFlow", "SQL", "Tableau", "Jupyter"];
    }
    if (category.includes("cloud")) {
        return ["AWS", "Docker", "Kubernetes", "Terraform", "Linux", "CI/CD"];
    }
    if (category.includes("cyber")) {
        return ["Network Security", "Penetration Testing", "Wireshark", "Kali Linux", "OWASP"];
    }
    return ["HTML5", "CSS3", "JavaScript", "React", "Node.js", "Git"];
});

// Upcoming Batches - from course data or defaults
const upcomingBatches = computed(() => {
    if (courseData.value?.course?.upcoming_batches?.length) {
        return courseData.value.course.upcoming_batches;
    }
    // Default upcoming batches
    return [
        { date: "July 1, 2026", time: "10:00 AM - 12:00 PM", seats: 15 },
        { date: "July 15, 2026", time: "6:00 PM - 8:00 PM", seats: 22 },
        { date: "August 1, 2026", time: "10:00 AM - 12:00 PM", seats: 0 },
    ];
});

// Career Outcomes - from course data or defaults
const careerOutcomes = computed(() => {
    if (courseData.value?.course?.career_outcomes?.length) {
        return courseData.value.course.career_outcomes;
    }
    // Default career outcomes
    return [
        { role: "Full-Stack Developer", salary: "₹5,00,000 - ₹12,00,000 / year" },
        { role: "Frontend Engineer", salary: "₹4,50,000 - ₹10,00,000 / year" },
        { role: "Backend Developer", salary: "₹5,00,000 - ₹11,00,000 / year" },
        { role: "Software Engineer", salary: "₹6,00,000 - ₹14,00,000 / year" },
    ];
});

// Fetch course data
const fetchCourseData = async () => {
    try {
        const response = await axios.get(`/course/show/${course_id}`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${authStore.authToken}`,
            },
        });
        courseData.value = response.data.data;

    } catch (error) {
        console.error("Error fetching course data:", error);
    }
};

onMounted(async () => {
    await fetchCourseData();
    localStorage.removeItem("handle_course_id");
    window.scrollTo(0, 0);
});
</script>

<style scoped>
/* PrimeVue TabView overrides for course detail tabs */
.course-detail-tabs :deep(.p-tabview-nav) {
    border: none;
    background: transparent;
    gap: 0;
}

.course-detail-tabs :deep(.p-tabview-nav-list) {
    display: flex;
    width: 100%;
    gap: 0;
    overflow-x: auto;
}

.course-detail-tabs :deep(.p-tabview-nav-list li) {
    flex: 1;
}

.course-detail-tabs :deep(.p-tabview-nav-list li .p-tabview-nav-link) {
    border: none;
    background: transparent;
    color: #64748b;
    border-bottom: 2px solid transparent;
    border-radius: 0;
    padding: 1rem 1.25rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.course-detail-tabs :deep(.p-tabview-nav-list li .p-tabview-nav-link:hover) {
    color: #15803d;
    background: transparent;
}

.course-detail-tabs :deep(.p-tabview-nav-list li.p-highlight .p-tabview-nav-link) {
    color: #15803d;
    border-bottom: 2px solid #15803d;
    background: transparent;
    box-shadow: none;
}

.course-detail-tabs :deep(.p-tabview-panels) {
    padding: 0;
    background: transparent;
    border: none;
}

.course-detail-tabs :deep(.p-tabview-panel) {
    padding: 0;
}
</style>
