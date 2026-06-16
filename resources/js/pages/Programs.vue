<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30">
        <!-- Hero Banner -->
        <section class="relative py-12 md:py-16 overflow-hidden">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
                    Our Programs
                </h1>
                <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto">
                    18 industry-ready programs designed to launch your tech career
                </p>
            </div>
        </section>

        <!-- Filter Tabs -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
            <div class="bg-white rounded-2xl shadow-lg p-2 flex flex-wrap gap-2 justify-center">
                <button
                    v-for="cat in categories"
                    :key="cat.key"
                    @click="activeCategory = cat.key"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                    :class="activeCategory === cat.key ? 'bg-primary-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100'"
                >
                    {{ cat.label }}
                </button>
            </div>
        </section>

        <!-- Programs Grid -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <router-link
                    v-for="(program, index) in filteredPrograms"
                    :key="program.id"
                    :to="`/programs/${program.slug}`"
                    class="group relative bg-white rounded-2xl p-6 border border-slate-100 hover:border-primary-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer"
                    :style="{ animationDelay: `${index * 0.05}s` }"
                >
                    <!-- Featured Badge -->
                    <div
                        v-if="program.featured"
                        class="absolute -top-3 left-4 px-3 py-1 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold rounded-full shadow-md"
                    >
                        FEATURED
                    </div>

                    <!-- Highlight Badge -->
                    <div
                        v-if="program.highlight"
                        class="absolute -top-3 left-4 px-3 py-1 bg-gradient-to-r from-green-400 to-emerald-500 text-white text-xs font-bold rounded-full shadow-md"
                    >
                        {{ program.badge }}
                    </div>

                    <!-- Icon -->
                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl mb-4 shadow-lg transition-transform group-hover:scale-110"
                        :class="getColorClasses(program.color).iconBg"
                    >
                        <i :class="program.icon"></i>
                    </div>

                    <!-- Content -->
                    <h3 class="text-lg font-bold text-navy mb-2 group-hover:text-primary-700 transition-colors">
                        {{ program.name }}
                    </h3>
                    <p class="text-slate text-sm mb-4 leading-relaxed line-clamp-2">
                        {{ program.description }}
                    </p>

                    <!-- Meta -->
                    <div class="flex flex-wrap items-center gap-3 mb-4 text-sm">
                        <span class="inline-flex items-center gap-1.5 text-slate font-medium">
                            <i class="bi bi-clock text-primary-500"></i>
                            {{ program.duration }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-slate font-medium">
                            <i class="bi bi-currency-rupee text-primary-500"></i>
                            {{ program.salary }}
                        </span>
                    </div>

                    <!-- Tech Stack -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span
                            v-for="tech in program.tech.slice(0, 4)"
                            :key="tech"
                            class="px-2.5 py-1 rounded-lg bg-slate-50 text-xs font-semibold text-slate-600 border border-slate-100"
                        >
                            {{ tech }}
                        </span>
                        <span
                            v-if="program.tech.length > 4"
                            class="px-2.5 py-1 rounded-lg bg-slate-50 text-xs font-semibold text-slate-400"
                        >
                            +{{ program.tech.length - 4 }}
                        </span>
                    </div>

                    <!-- CTA -->
                    <span
                        class="inline-flex items-center gap-2 font-bold text-sm transition-all duration-200 group-hover:gap-3"
                        :class="getColorClasses(program.color).text"
                    >
                        View Program
                        <i class="bi bi-arrow-right text-sm"></i>
                    </span>
                </router-link>
            </div>

            <!-- Empty State -->
            <div v-if="filteredPrograms.length === 0" class="text-center py-16">
                <i class="bi bi-inbox text-5xl text-slate-300 mb-4"></i>
                <p class="text-slate text-lg">No programs found in this category.</p>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-primary-600 to-indigo-700 py-16">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-extrabold text-white mb-4">Ready to Start Your Journey?</h2>
                <p class="text-white/80 mb-8 text-lg">Join thousands of students who have transformed their careers with Edutantr.</p>
                <router-link
                    to="/contact-us"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-slate-50 transition-all duration-200 shadow-lg hover:shadow-xl"
                >
                    Get in Touch
                    <i class="bi bi-arrow-right"></i>
                </router-link>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const activeCategory = ref("all");

const categories = [
    { key: "all", label: "All" },
    { key: "featured", label: "Featured" },
    { key: "technology", label: "Technology" },
    { key: "data", label: "Data & Analytics" },
    { key: "business", label: "Business" },
    { key: "hardware", label: "Hardware" },
];

const programs = [
    { id: 1, slug: "full-stack-web-development", name: "Full Stack Web Development", duration: "6 Months", salary: "₹4-12 LPA", icon: "bi bi-code-slash", color: "blue", featured: true, category: "technology", description: "Master React, Node.js, databases, and deployment. Build complete web applications from scratch.", tech: ["React", "Node.js", "MongoDB", "AWS", "JavaScript", "HTML/CSS"] },
    { id: 2, slug: "ai-machine-learning", name: "Artificial Intelligence with Machine Learning", duration: "6 Months", salary: "₹5-15 LPA", icon: "bi bi-robot", color: "purple", featured: true, category: "technology", description: "Build intelligent systems using Python, TensorFlow, and deep learning algorithms.", tech: ["Python", "TensorFlow", "PyTorch", "Scikit-learn", "Neural Networks"] },
    { id: 3, slug: "data-science", name: "Data Science", duration: "5 Months", salary: "₹4-12 LPA", icon: "bi bi-graph-up-arrow", color: "emerald", featured: true, category: "data", description: "Analyze data, build models, and create visualizations that drive business decisions.", tech: ["Python", "SQL", "Power BI", "Excel", "Statistics"] },
    { id: 4, slug: "devops", name: "DevOps", duration: "5 Months", salary: "₹5-14 LPA", icon: "bi bi-gear-wide-connected", color: "cyan", category: "technology", description: "Master CI/CD pipelines, containerization, and cloud infrastructure automation.", tech: ["Docker", "Kubernetes", "Jenkins", "Ansible", "Linux"] },
    { id: 5, slug: "software-testing", name: "Software Testing", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-bug-fill", color: "red", category: "technology", description: "Manual and automation testing with Selenium, JIRA, and test frameworks.", tech: ["Selenium", "JIRA", "TestNG", "Postman", "JMeter"] },
    { id: 6, slug: "python-power-bi", name: "Python with Power BI", duration: "5 Months", salary: "₹4-10 LPA", icon: "bi bi-filetype-py", color: "amber", category: "data", description: "Data analysis and visualization using Python and Microsoft Power BI.", tech: ["Python", "Power BI", "Pandas", "NumPy", "Matplotlib"] },
    { id: 7, slug: "application-development", name: "Application Development", duration: "6 Months", salary: "₹4-12 LPA", icon: "bi bi-phone", color: "indigo", category: "technology", description: "Build cross-platform mobile and web applications with modern frameworks.", tech: ["React Native", "Flutter", "Firebase", "Dart", "Swift"] },
    { id: 8, slug: "data-analytics", name: "Data Analytics / Business Analytics", duration: "5 Months", salary: "₹3.5-10 LPA", icon: "bi bi-bar-chart-line-fill", color: "teal", category: "data", description: "Transform raw data into actionable business insights using analytics tools.", tech: ["Excel", "SQL", "Power BI", "Tableau", "Google Analytics"] },
    { id: 9, slug: "cyber-security", name: "Cyber Security", duration: "6 Months", salary: "₹5-15 LPA", icon: "bi bi-shield-lock-fill", color: "rose", category: "technology", description: "Protect systems from threats with ethical hacking, network security, and compliance.", tech: ["Ethical Hacking", "Network Security", "SIEM", "Firewalls", "Compliance"] },
    { id: 10, slug: "embedded-systems", name: "Embedded Systems", duration: "5 Months", salary: "₹3.5-10 LPA", icon: "bi bi-cpu", color: "slate", category: "hardware", description: "Program microcontrollers and build IoT devices with C, C++, and Arduino.", tech: ["C", "C++", "Arduino", "Raspberry Pi", "IoT"] },
    { id: 11, slug: "vlsi", name: "VLSI", duration: "6 Months", salary: "₹4-12 LPA", icon: "bi bi-chip", color: "violet", category: "hardware", description: "Design and verify integrated circuits using Verilog, VHDL, and EDA tools.", tech: ["Verilog", "VHDL", "Cadence", "Synopsys", "Linux"] },
    { id: 12, slug: "digital-marketing", name: "Digital Marketing", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-megaphone-fill", color: "pink", category: "business", description: "Master SEO, SEM, social media marketing, and Google Ads campaigns.", tech: ["SEO", "Google Ads", "Social Media", "Analytics", "Content Marketing"] },
    { id: 13, slug: "business-growth", name: "Business Growth Specialist", duration: "4 Months", salary: "₹4-10 LPA", icon: "bi bi-trophy-fill", color: "amber", category: "business", description: "100% Placement Guarantee or 100% Refund. Master business strategy and growth.", tech: ["Strategy", "Sales", "Marketing", "Leadership", "Growth Hacking"], highlight: true, badge: "100% Placement Guarantee" },
    { id: 14, slug: "hr-management", name: "Human Resource Management", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-people-fill", color: "sky", category: "business", description: "HR operations, recruitment, payroll, and employee management systems.", tech: ["HRIS", "Recruitment", "Payroll", "Labour Laws", "Performance Mgmt"] },
    { id: 15, slug: "cloud-computing", name: "Cloud Computing", duration: "6 Months", salary: "₹5-15 LPA", icon: "bi bi-cloud-fill", color: "blue", category: "technology", description: "AWS, Azure, GCP — architect and manage enterprise cloud infrastructure.", tech: ["AWS", "Azure", "GCP", "Docker", "Terraform"] },
    { id: 16, slug: "ui-ux", name: "UI/UX", duration: "4 Months", salary: "₹3.5-10 LPA", icon: "bi bi-palette-fill", color: "fuchsia", category: "technology", description: "Design beautiful, user-friendly interfaces with Figma and design thinking.", tech: ["Figma", "Adobe XD", "Prototyping", "User Research", "Wireframing"] },
    { id: 17, slug: "finance-tally", name: "Finance & Tally", duration: "4 Months", salary: "₹2.5-7 LPA", icon: "bi bi-calculator-fill", color: "green", category: "business", description: "Accounting, taxation, GST, and Tally ERP with practical exercises.", tech: ["Tally", "GST", "Income Tax", "Accounting", "Excel"] },
    { id: 18, slug: "medical-coding", name: "Medical Coding", duration: "4 Months", salary: "₹3-8 LPA", icon: "bi bi-heart-pulse-fill", color: "red", category: "technology", description: "ICD-10, CPT, HIPAA compliance, and healthcare data management.", tech: ["ICD-10", "CPT", "HIPAA", "Medical Terminology", "AHIMA"] },
];

const filteredPrograms = computed(() => {
    if (activeCategory.value === "all") return programs;
    if (activeCategory.value === "featured") return programs.filter((p) => p.featured);
    return programs.filter((p) => p.category === activeCategory.value);
});

const getColorClasses = (color) => {
    const map = {
        blue: { iconBg: "bg-gradient-to-br from-blue-500 to-indigo-600", text: "text-blue-600 hover:text-blue-700" },
        purple: { iconBg: "bg-gradient-to-br from-purple-500 to-violet-600", text: "text-purple-600 hover:text-purple-700" },
        emerald: { iconBg: "bg-gradient-to-br from-emerald-500 to-teal-600", text: "text-emerald-600 hover:text-emerald-700" },
        cyan: { iconBg: "bg-gradient-to-br from-cyan-500 to-blue-600", text: "text-cyan-600 hover:text-cyan-700" },
        red: { iconBg: "bg-gradient-to-br from-red-500 to-rose-600", text: "text-red-600 hover:text-red-700" },
        amber: { iconBg: "bg-gradient-to-br from-amber-500 to-orange-600", text: "text-amber-600 hover:text-amber-700" },
        indigo: { iconBg: "bg-gradient-to-br from-indigo-500 to-blue-600", text: "text-indigo-600 hover:text-indigo-700" },
        teal: { iconBg: "bg-gradient-to-br from-teal-500 to-cyan-600", text: "text-teal-600 hover:text-teal-700" },
        rose: { iconBg: "bg-gradient-to-br from-rose-500 to-pink-600", text: "text-rose-600 hover:text-rose-700" },
        slate: { iconBg: "bg-gradient-to-br from-slate-500 to-gray-600", text: "text-slate-600 hover:text-slate-700" },
        violet: { iconBg: "bg-gradient-to-br from-violet-500 to-purple-600", text: "text-violet-600 hover:text-violet-700" },
        pink: { iconBg: "bg-gradient-to-br from-pink-500 to-rose-600", text: "text-pink-600 hover:text-pink-700" },
        sky: { iconBg: "bg-gradient-to-br from-sky-500 to-blue-600", text: "text-sky-600 hover:text-sky-700" },
        fuchsia: { iconBg: "bg-gradient-to-br from-fuchsia-500 to-purple-600", text: "text-fuchsia-600 hover:text-fuchsia-700" },
        green: { iconBg: "bg-gradient-to-br from-green-500 to-emerald-600", text: "text-green-600 hover:text-green-700" },
    };
    return map[color] || map.blue;
};
</script>
