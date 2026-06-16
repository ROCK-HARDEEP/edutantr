<template>
    <div class="w-full overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-slate-200 shadow-sm text-slate-500 text-sm font-semibold mb-4">
                <i class="bi bi-bar-chart-fill text-slate-400"></i>
                {{ $t('Top Popular Courses') }}
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-navy leading-tight tracking-tight">
                {{ $t('All The Skills You Need In One Place') }}
            </h2>
        </div>

        <!-- Loading Skeleton -->
        <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            <div v-for="i in 3" :key="i" class="rounded-2xl border border-slate-100 overflow-hidden animate-pulse">
                <div class="h-52 bg-gradient-to-r from-slate-100 to-slate-50"></div>
                <div class="p-5">
                    <div class="h-4 bg-slate-100 rounded w-3/4 mb-3"></div>
                    <div class="h-3 bg-slate-50 rounded w-1/2 mb-2"></div>
                    <div class="h-3 bg-slate-50 rounded w-2/3"></div>
                </div>
            </div>
        </div>

        <!-- Course Grid -->
        <div v-else-if="displayCourses.length" class="grid grid-cols-1 md:grid-cols-3 gap-7">
                <div
                    v-for="(course, index) in displayCourses.slice(0, 3)"
                    :key="`popular-${course.id}-${index}`"
                >
                    <router-link :to="course.link || `/programs/${course.slug}`" class="block">
                        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:border-orange-100 transition-colors duration-300 hover:-translate-y-1.5 transition-transform h-full">
                            <!-- Icon header -->
                            <div class="h-40 flex items-center justify-center relative" :class="course.bgClass">
                                <i :class="course.icon" class="text-5xl opacity-80"></i>
                                <span v-if="course.badge" class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-amber-500 text-white text-[10px] font-bold uppercase tracking-wider">
                                    {{ course.badge }}
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-navy text-base mb-2 line-clamp-2">{{ course.name }}</h3>
                                <div class="flex items-center gap-3 text-xs text-slate-500 mb-3">
                                    <span class="inline-flex items-center gap-1"><i class="bi bi-clock"></i> {{ course.duration }}</span>
                                    <span class="inline-flex items-center gap-1"><i class="bi bi-currency-rupee"></i> {{ course.salary }}</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span v-for="tech in course.tech.slice(0, 3)" :key="tech" class="px-2 py-0.5 rounded-md bg-slate-50 text-slate-600 text-[11px] font-medium border border-slate-100">
                                        {{ tech }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16">
            <i class="bi bi-journal-x text-slate-300 text-5xl mb-3 block"></i>
            <h4 class="font-semibold text-slate-400">{{ $t('No courses found') }}</h4>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

const allCourses = [
    { id: 1, slug: "full-stack-web-development", name: "Full Stack Web Development", duration: "6 Months", salary: "₹4-12 LPA", icon: "bi bi-code-slash", bgClass: "bg-gradient-to-br from-blue-500 to-indigo-600 text-white", tech: ["React", "Node.js", "MongoDB", "AWS"] },
    { id: 2, slug: "ai-machine-learning", name: "Artificial Intelligence with Machine Learning", duration: "6 Months", salary: "₹5-15 LPA", icon: "bi bi-robot", bgClass: "bg-gradient-to-br from-purple-500 to-violet-600 text-white", tech: ["Python", "TensorFlow", "PyTorch", "Scikit-learn"] },
    { id: 3, slug: "data-science", name: "Data Science", duration: "5 Months", salary: "₹4-12 LPA", icon: "bi bi-graph-up-arrow", bgClass: "bg-gradient-to-br from-emerald-500 to-teal-600 text-white", tech: ["Python", "SQL", "Power BI", "Excel"], badge: "Popular" },
    { id: 4, slug: "devops", name: "DevOps", duration: "5 Months", salary: "₹5-14 LPA", icon: "bi bi-gear-wide-connected", bgClass: "bg-gradient-to-br from-cyan-500 to-blue-600 text-white", tech: ["Docker", "Kubernetes", "Jenkins", "Ansible"] },
    { id: 5, slug: "software-testing", name: "Software Testing", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-bug-fill", bgClass: "bg-gradient-to-br from-red-500 to-rose-600 text-white", tech: ["Selenium", "JIRA", "TestNG", "Postman"] },
    { id: 6, slug: "python-power-bi", name: "Python with Power BI", duration: "5 Months", salary: "₹4-10 LPA", icon: "bi bi-filetype-py", bgClass: "bg-gradient-to-br from-amber-500 to-orange-600 text-white", tech: ["Python", "Power BI", "Pandas", "NumPy"] },
    { id: 7, slug: "application-development", name: "Application Development", duration: "6 Months", salary: "₹4-12 LPA", icon: "bi bi-phone", bgClass: "bg-gradient-to-br from-indigo-500 to-blue-600 text-white", tech: ["React Native", "Flutter", "Firebase", "Dart"] },
    { id: 8, slug: "data-analytics", name: "Data Analytics / Business Analytics", duration: "5 Months", salary: "₹3.5-10 LPA", icon: "bi bi-bar-chart-line-fill", bgClass: "bg-gradient-to-br from-teal-500 to-cyan-600 text-white", tech: ["Excel", "SQL", "Power BI", "Tableau"] },
    { id: 9, slug: "cyber-security", name: "Cyber Security", duration: "6 Months", salary: "₹5-15 LPA", icon: "bi bi-shield-lock-fill", bgClass: "bg-gradient-to-br from-rose-500 to-red-600 text-white", tech: ["Ethical Hacking", "Network Security", "SIEM"] },
    { id: 10, slug: "embedded-systems", name: "Embedded Systems", duration: "5 Months", salary: "₹3.5-10 LPA", icon: "bi bi-cpu", bgClass: "bg-gradient-to-br from-slate-500 to-gray-600 text-white", tech: ["C", "C++", "Arduino", "IoT"] },
    { id: 11, slug: "vlsi", name: "VLSI", duration: "6 Months", salary: "₹4-12 LPA", icon: "bi bi-chip", bgClass: "bg-gradient-to-br from-violet-500 to-purple-600 text-white", tech: ["Verilog", "VHDL", "Cadence", "Synopsys"] },
    { id: 12, slug: "digital-marketing", name: "Digital Marketing", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-megaphone-fill", bgClass: "bg-gradient-to-br from-pink-500 to-rose-500 text-white", tech: ["SEO", "Google Ads", "Social Media", "Analytics"] },
    { id: 13, slug: "business-growth", name: "Business Growth Specialist", duration: "4 Months", salary: "₹4-10 LPA", icon: "bi bi-trophy-fill", bgClass: "bg-gradient-to-br from-amber-500 to-yellow-500 text-white", tech: ["Strategy", "Sales", "Marketing", "Leadership"], badge: "100% Placement" },
    { id: 14, slug: "hr-management", name: "Human Resource Management", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-people-fill", bgClass: "bg-gradient-to-br from-sky-500 to-blue-500 text-white", tech: ["HRIS", "Recruitment", "Payroll", "Labour Laws"] },
    { id: 15, slug: "cloud-computing", name: "Cloud Computing", duration: "6 Months", salary: "₹5-15 LPA", icon: "bi bi-cloud-fill", bgClass: "bg-gradient-to-br from-blue-500 to-indigo-500 text-white", tech: ["AWS", "Azure", "GCP", "Docker"] },
    { id: 16, slug: "ui-ux", name: "UI/UX", duration: "4 Months", salary: "₹3.5-10 LPA", icon: "bi bi-palette-fill", bgClass: "bg-gradient-to-br from-fuchsia-500 to-pink-500 text-white", tech: ["Figma", "Adobe XD", "Prototyping", "User Research"] },
    { id: 17, slug: "finance-tally", name: "Finance & Tally", duration: "4 Months", salary: "₹2.5-7 LPA", icon: "bi bi-calculator-fill", bgClass: "bg-gradient-to-br from-green-500 to-emerald-600 text-white", tech: ["Tally", "GST", "Income Tax", "Accounting"] },
    { id: 18, slug: "medical-coding", name: "Medical Coding", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-heart-pulse-fill", bgClass: "bg-gradient-to-br from-red-500 to-pink-500 text-white", tech: ["ICD-10", "CPT", "HIPAA", "Medical Terminology"] },
];

const popularCourses = ref([]);
const isLoading = ref(true);

const displayCourses = computed(() => {
    return popularCourses.value.length ? popularCourses.value : allCourses;
});

onMounted(async () => {
    try {
        const response = await axios.get(`/course/list`, {
            headers: { "Content-Type": "application/json", Accept: "application/json" },
            params: { items_per_page: 12, page_number: 1, sort: "view_count", sortDirection: "desc" },
        });
        const apiCourses = response.data.data.courses ?? [];
        if (apiCourses.length > 0) popularCourses.value = apiCourses;
    } catch (error) {
        console.error("Error fetching courses:", error);
    } finally {
        isLoading.value = false;
    }
});
</script>

<style scoped>
</style>
