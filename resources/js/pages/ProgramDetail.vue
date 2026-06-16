<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav class="flex items-center gap-2 text-sm text-slate-500">
                    <router-link to="/" class="hover:text-primary-600 transition-colors">Home</router-link>
                    <i class="bi bi-chevron-right text-xs"></i>
                    <router-link to="/programs" class="hover:text-primary-600 transition-colors">Programs</router-link>
                    <i class="bi bi-chevron-right text-xs"></i>
                    <span class="text-navy font-medium">{{ program?.name }}</span>
                </nav>
            </div>
        </div>

        <!-- Not Found -->
        <div v-if="!program" class="max-w-4xl mx-auto px-4 py-20 text-center">
            <i class="bi bi-exclamation-triangle text-5xl text-amber-400 mb-4"></i>
            <h2 class="text-2xl font-bold text-navy mb-2">Program Not Found</h2>
            <p class="text-slate mb-6">The program you're looking for doesn't exist.</p>
            <router-link to="/programs" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all">
                <i class="bi bi-arrow-left"></i>
                Back to Programs
            </router-link>
        </div>

        <template v-else>
            <!-- Hero Section -->
            <section class="relative py-16 md:py-24 overflow-hidden" :class="heroGradient">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-3xl shadow-2xl" :class="iconBg">
                            <i :class="program.icon"></i>
                        </div>
                        <div class="flex-1">
                            <div v-if="program.featured" class="inline-block px-3 py-1 bg-amber-400 text-amber-900 text-xs font-bold rounded-full mb-3">
                                FEATURED PROGRAM
                            </div>
                            <div v-if="program.highlight" class="inline-block px-3 py-1 bg-green-400 text-green-900 text-xs font-bold rounded-full mb-3">
                                {{ program.badge }}
                            </div>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">{{ program.name }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-white/90">
                                <span class="inline-flex items-center gap-2">
                                    <i class="bi bi-clock"></i>
                                    {{ program.duration }}
                                </span>
                                <span class="inline-flex items-center gap-2">
                                    <i class="bi bi-currency-rupee"></i>
                                    {{ program.salary }}
                                </span>
                            </div>
                        </div>
                        <router-link
                            to="/contact-us"
                            class="px-8 py-4 bg-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200"
                            :class="textColor"
                        >
                            Enroll Now
                            <i class="bi bi-arrow-right ml-1"></i>
                        </router-link>
                    </div>
                </div>
            </section>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Program Overview -->
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm">
                            <h2 class="text-2xl font-bold text-navy mb-4 flex items-center gap-2">
                                <i class="bi bi-info-circle text-primary-500"></i>
                                Program Overview
                            </h2>
                            <p class="text-slate leading-relaxed">{{ program.description }}</p>
                        </div>

                        <!-- What You'll Learn -->
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm">
                            <h2 class="text-2xl font-bold text-navy mb-6 flex items-center gap-2">
                                <i class="bi bi-lightbulb text-amber-500"></i>
                                What You'll Learn
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div
                                    v-for="(outcome, idx) in program.outcomes"
                                    :key="idx"
                                    class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100"
                                >
                                    <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                                    <span class="text-slate text-sm font-medium">{{ outcome }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tech Stack -->
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm">
                            <h2 class="text-2xl font-bold text-navy mb-6 flex items-center gap-2">
                                <i class="bi bi-tools text-primary-500"></i>
                                Technology Stack
                            </h2>
                            <div class="flex flex-wrap gap-3">
                                <span
                                    v-for="tech in program.tech"
                                    :key="tech"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold border"
                                    :class="techBadgeClasses"
                                >
                                    {{ tech }}
                                </span>
                            </div>
                        </div>

                        <!-- Career Opportunities -->
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm">
                            <h2 class="text-2xl font-bold text-navy mb-6 flex items-center gap-2">
                                <i class="bi bi-briefcase text-emerald-500"></i>
                                Career Opportunities
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div
                                    v-for="(role, idx) in program.jobRoles"
                                    :key="idx"
                                    class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-100"
                                >
                                    <i class="bi bi-person-check text-emerald-600"></i>
                                    <span class="text-slate text-sm font-semibold">{{ role }}</span>
                                </div>
                            </div>
                            <div class="mt-6 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100">
                                <div class="flex items-center gap-2 text-emerald-700 font-bold">
                                    <i class="bi bi-cash-stack"></i>
                                    Expected Salary: {{ program.salary }}
                                </div>
                            </div>
                        </div>

                        <!-- Why Choose This Program -->
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm">
                            <h2 class="text-2xl font-bold text-navy mb-6 flex items-center gap-2">
                                <i class="bi bi-star text-amber-500"></i>
                                Why Choose This Program
                            </h2>
                            <div class="space-y-4">
                                <div
                                    v-for="(benefit, idx) in program.benefits"
                                    :key="idx"
                                    class="flex items-start gap-3"
                                >
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-primary-100">
                                        <i class="bi bi-check2 text-primary-600"></i>
                                    </div>
                                    <span class="text-slate text-sm leading-relaxed pt-1">{{ benefit }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ -->
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm">
                            <h2 class="text-2xl font-bold text-navy mb-6 flex items-center gap-2">
                                <i class="bi bi-question-circle text-primary-500"></i>
                                Frequently Asked Questions
                            </h2>
                            <div class="space-y-4">
                                <div
                                    v-for="(faq, idx) in program.faqs"
                                    :key="idx"
                                    class="border border-slate-100 rounded-xl overflow-hidden"
                                >
                                    <button
                                        @click="toggleFaq(idx)"
                                        class="w-full flex items-center justify-between p-4 text-left hover:bg-slate-50 transition-colors"
                                    >
                                        <span class="font-semibold text-navy text-sm">{{ faq.q }}</span>
                                        <i
                                            class="bi transition-transform duration-200"
                                            :class="openFaq === idx ? 'bi-chevron-up rotate-180' : 'bi-chevron-down'"
                                        ></i>
                                    </button>
                                    <div
                                        v-if="openFaq === idx"
                                        class="px-4 pb-4 text-slate text-sm leading-relaxed"
                                    >
                                        {{ faq.a }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm sticky top-24">
                            <h3 class="text-lg font-bold text-navy mb-4">Program Details</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                                    <span class="text-slate text-sm">Duration</span>
                                    <span class="font-semibold text-navy text-sm">{{ program.duration }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                                    <span class="text-slate text-sm">Salary Range</span>
                                    <span class="font-semibold text-navy text-sm">{{ program.salary }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                                    <span class="text-slate text-sm">Technologies</span>
                                    <span class="font-semibold text-navy text-sm">{{ program.tech.length }}</span>
                                </div>
                            </div>
                            <router-link
                                to="/contact-us"
                                class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all duration-200 shadow-lg"
                            >
                                Enroll Now
                                <i class="bi bi-arrow-right"></i>
                            </router-link>
                        </div>

                        <!-- Other Programs -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                            <h3 class="text-lg font-bold text-navy mb-4">Other Programs</h3>
                            <div class="space-y-3">
                                <router-link
                                    v-for="other in relatedPrograms"
                                    :key="other.id"
                                    :to="`/programs/${other.slug}`"
                                    class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group"
                                >
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-sm" :class="getIconBg(other.color)">
                                        <i :class="other.icon"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-navy group-hover:text-primary-700 truncate">{{ other.name }}</p>
                                        <p class="text-xs text-slate">{{ other.duration }} · {{ other.salary }}</p>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const route = useRoute();
const openFaq = ref(null);

const programs = [
    {
        id: 1, slug: "full-stack-web-development", name: "Full Stack Web Development", duration: "6 Months", salary: "₹4-12 LPA",
        icon: "bi bi-code-slash", color: "blue", featured: true, category: "technology",
        description: "Master React, Node.js, databases, and deployment. Build complete web applications from scratch. This comprehensive program covers frontend development with React, backend with Node.js and Express, database management with MongoDB and PostgreSQL, and cloud deployment on AWS.",
        tech: ["React", "Node.js", "MongoDB", "AWS", "JavaScript", "HTML/CSS"],
        outcomes: [
            "Build full-stack web applications using React and Node.js",
            "Design and implement RESTful APIs and GraphQL endpoints",
            "Work with MongoDB and SQL databases effectively",
            "Deploy applications to AWS with CI/CD pipelines",
        ],
        jobRoles: ["Full Stack Developer", "Frontend Developer", "Backend Developer", "Web Application Engineer"],
        benefits: [
            "Industry-aligned curriculum updated quarterly with latest tech trends",
            "Hands-on project-based learning with real-world applications",
            "100% placement assistance with resume building and interview prep",
            "Lifetime access to course materials and community support",
        ],
        faqs: [
            { q: "Do I need prior coding experience?", a: "No prior experience is required. The program starts from fundamentals and progressively moves to advanced topics. However, basic computer literacy is helpful." },
            { q: "What kind of projects will I build?", a: "You'll build 5+ real-world projects including e-commerce platforms, social media dashboards, and portfolio websites. These projects will form your professional portfolio." },
            { q: "Is there a placement guarantee?", a: "We provide 100% placement assistance including resume reviews, mock interviews, and direct referrals to our hiring partners. Many students receive offers within 2-3 months of completing the program." },
        ],
    },
    {
        id: 2, slug: "ai-machine-learning", name: "Artificial Intelligence with Machine Learning", duration: "6 Months", salary: "₹5-15 LPA",
        icon: "bi bi-robot", color: "purple", featured: true, category: "technology",
        description: "Build intelligent systems using Python, TensorFlow, and deep learning algorithms. From foundational ML concepts to advanced neural networks and NLP, this program prepares you for the fastest-growing field in tech.",
        tech: ["Python", "TensorFlow", "PyTorch", "Scikit-learn", "Neural Networks"],
        outcomes: [
            "Build machine learning models for classification, regression, and clustering",
            "Develop deep learning solutions with TensorFlow and PyTorch",
            "Implement NLP systems for text analysis and chatbots",
            "Deploy ML models to production environments",
        ],
        jobRoles: ["ML Engineer", "AI Developer", "Data Scientist", "NLP Engineer"],
        benefits: [
            "Learn from industry practitioners working at top AI companies",
            "Access to GPU-equipped labs for hands-on deep learning training",
            "Portfolio of AI projects including computer vision and NLP applications",
            "Industry-recognized certification upon completion",
        ],
        faqs: [
            { q: "Is a math background required?", a: "Basic understanding of mathematics (algebra, statistics) is helpful. We include a math refresher module at the start to ensure everyone is on the same page." },
            { q: "What hardware/software do I need?", a: "A laptop with at least 8GB RAM is sufficient. We provide cloud-based GPU access for deep learning projects, so you don't need a high-end GPU on your local machine." },
            { q: "Can I specialize in a specific area of AI?", a: "Yes! In the final month, you can choose a specialization track: Computer Vision, NLP, or Reinforcement Learning. Each track includes a capstone project." },
        ],
    },
    {
        id: 3, slug: "data-science", name: "Data Science", duration: "5 Months", salary: "₹4-12 LPA",
        icon: "bi bi-graph-up-arrow", color: "emerald", featured: true, category: "data",
        description: "Analyze data, build models, and create visualizations that drive business decisions. Master Python, SQL, Power BI, and statistical analysis to become a complete data professional.",
        tech: ["Python", "SQL", "Power BI", "Excel", "Statistics"],
        outcomes: [
            "Perform statistical analysis and hypothesis testing",
            "Build predictive models using Python and Scikit-learn",
            "Create interactive dashboards with Power BI and Tableau",
            "Write complex SQL queries for data extraction and transformation",
        ],
        jobRoles: ["Data Scientist", "Data Analyst", "Business Intelligence Analyst", "Analytics Engineer"],
        benefits: [
            "Work with real-world datasets from various industries",
            "Learn industry-standard tools used by Fortune 500 companies",
            "Build a professional portfolio with 4+ capstone projects",
            "Get mentored by experienced data professionals",
        ],
        faqs: [
            { q: "Do I need to know programming?", a: "No programming background is needed. We start with Python basics and gradually build up to advanced data analysis techniques." },
            { q: "What industries can I work in?", a: "Data science skills are applicable across all industries — finance, healthcare, e-commerce, marketing, manufacturing, and more. Every company needs data professionals." },
            { q: "How is this different from Data Analytics?", a: "Data Science includes advanced statistical modeling, machine learning, and predictive analytics, while Data Analytics focuses more on descriptive analysis and visualization. Both are valuable career paths." },
        ],
    },
    {
        id: 4, slug: "devops", name: "DevOps", duration: "5 Months", salary: "₹5-14 LPA",
        icon: "bi bi-gear-wide-connected", color: "cyan", category: "technology",
        description: "Master CI/CD pipelines, containerization, and cloud infrastructure automation. Learn to bridge the gap between development and operations for faster, more reliable software delivery.",
        tech: ["Docker", "Kubernetes", "Jenkins", "Ansible", "Linux"],
        outcomes: [
            "Set up CI/CD pipelines with Jenkins and GitHub Actions",
            "Containerize applications with Docker and orchestrate with Kubernetes",
            "Automate infrastructure provisioning with Terraform and Ansible",
            "Monitor and log applications using Prometheus and ELK stack",
        ],
        jobRoles: ["DevOps Engineer", "Site Reliability Engineer", "Cloud Engineer", "Infrastructure Engineer"],
        benefits: [
            "Hands-on labs with real cloud infrastructure on AWS and Azure",
            "Industry certification preparation included (AWS, Kubernetes)",
            "Learn from DevOps practitioners at top tech companies",
            "Master in-demand skills with 40%+ YoY job growth",
        ],
        faqs: [
            { q: "Do I need Linux experience?", a: "Basic Linux command-line knowledge is helpful but not required. We include a Linux fundamentals module at the start of the program." },
            { q: "Which cloud platform will I learn?", a: "The program covers AWS primarily, with supplementary modules on Azure and GCP. You'll gain practical experience with all three major platforms." },
            { q: "Is DevOps only for developers?", a: "DevOps is for anyone interested in software delivery automation. Many system administrators, QA engineers, and even project managers transition into DevOps roles." },
        ],
    },
    {
        id: 5, slug: "software-testing", name: "Software Testing", duration: "4 Months", salary: "₹3-8 LPA",
        icon: "bi bi-bug-fill", color: "red", category: "technology",
        description: "Manual and automation testing with Selenium, JIRA, and test frameworks. Learn to ensure software quality through systematic testing methodologies.",
        tech: ["Selenium", "JIRA", "TestNG", "Postman", "JMeter"],
        outcomes: [
            "Design comprehensive test plans and test cases",
            "Build automation test suites with Selenium WebDriver",
            "Perform API testing with Postman and RestAssured",
            "Execute performance testing using JMeter",
        ],
        jobRoles: ["QA Engineer", "Test Automation Engineer", "Software Tester", "Quality Analyst"],
        benefits: [
            "Learn both manual and automation testing methodologies",
            "Work with industry-standard tools used by top companies",
            "Build a testing portfolio with real project scenarios",
            "High demand for QA professionals across all tech companies",
        ],
        faqs: [
            { q: "Can non-technical people learn testing?", a: "Absolutely! Software testing is one of the most accessible entry points into tech. The program starts with manual testing concepts before advancing to automation." },
            { q: "Will I learn coding for automation?", a: "Yes, you'll learn Java basics for Selenium automation and API testing with Postman. No prior coding experience is needed." },
            { q: "What is the job market like for testers?", a: "QA professionals are in high demand. Every software company needs testers, and automation skills command premium salaries. The field offers excellent growth opportunities." },
        ],
    },
    {
        id: 6, slug: "python-power-bi", name: "Python with Power BI", duration: "5 Months", salary: "₹4-10 LPA",
        icon: "bi bi-filetype-py", color: "amber", category: "data",
        description: "Data analysis and visualization using Python and Microsoft Power BI. Combine Python's analytical power with Power BI's visualization capabilities.",
        tech: ["Python", "Power BI", "Pandas", "NumPy", "Matplotlib"],
        outcomes: [
            "Analyze and manipulate data with Pandas and NumPy",
            "Create stunning visualizations with Matplotlib and Seaborn",
            "Build interactive Power BI dashboards and reports",
            "Automate data pipelines with Python scripts",
        ],
        jobRoles: ["Data Analyst", "BI Developer", "Reporting Analyst", "Business Analyst"],
        benefits: [
            "Dual-skill program combining Python and Power BI expertise",
            "Microsoft Power BI certification preparation included",
            "Real-world projects with industry datasets",
            "High placement rate in analytics roles",
        ],
        faqs: [
            { q: "Do I need to know both Python and Power BI?", a: "No prior knowledge is needed. We teach both from scratch, showing how they complement each other for maximum analytical power." },
            { q: "Is Power BI certification included?", a: "We prepare you for the Microsoft Power BI Data Analyst certification. The exam fee is separate, but all preparation material is included." },
            { q: "Can I use these skills in any industry?", a: "Yes! Python and Power BI skills are applicable across all industries. Every business needs data analysis and reporting capabilities." },
        ],
    },
    {
        id: 7, slug: "application-development", name: "Application Development", duration: "6 Months", salary: "₹4-12 LPA",
        icon: "bi bi-phone", color: "indigo", category: "technology",
        description: "Build cross-platform mobile and web applications with modern frameworks. Master React Native and Flutter to ship apps to both iOS and Android.",
        tech: ["React Native", "Flutter", "Firebase", "Dart", "Swift"],
        outcomes: [
            "Build cross-platform mobile apps with React Native and Flutter",
            "Implement backend services with Firebase",
            "Publish apps to Google Play Store and Apple App Store",
            "Design responsive UIs for multiple screen sizes",
        ],
        jobRoles: ["Mobile App Developer", "Flutter Developer", "React Native Developer", "Full Stack Developer"],
        benefits: [
            "Learn two in-demand frameworks in one comprehensive program",
            "Ship real apps to app stores during the program",
            "Access to device labs for testing on real hardware",
            "Portfolio of 3+ published applications",
        ],
        faqs: [
            { q: "Do I need a Mac for iOS development?", a: "A Mac is needed for iOS testing and App Store deployment. However, you can develop and test Android apps on any operating system. We provide Mac lab access for iOS-specific tasks." },
            { q: "Which framework should I focus on — React Native or Flutter?", a: "We cover both equally so you can make informed career choices. React Native is more widely used in existing companies, while Flutter is gaining rapid adoption for new projects." },
            { q: "Will I build a complete app?", a: "Yes! You'll build 3 complete apps: a social media app, an e-commerce app, and your choice of a personal project. Each app goes from design to store deployment." },
        ],
    },
    {
        id: 8, slug: "data-analytics", name: "Data Analytics / Business Analytics", duration: "5 Months", salary: "₹3.5-10 LPA",
        icon: "bi bi-bar-chart-line-fill", color: "teal", category: "data",
        description: "Transform raw data into actionable business insights using analytics tools. Master Excel, SQL, Power BI, and Tableau for data-driven decision making.",
        tech: ["Excel", "SQL", "Power BI", "Tableau", "Google Analytics"],
        outcomes: [
            "Analyze business data with advanced Excel and SQL",
            "Build interactive dashboards with Power BI and Tableau",
            "Perform statistical analysis for business insights",
            "Track and optimize digital marketing analytics",
        ],
        jobRoles: ["Business Analyst", "Data Analyst", "BI Analyst", "Marketing Analyst"],
        benefits: [
            "Learn the most in-demand analytics tools in the market",
            "Work with real business case studies and datasets",
            "Excel certification and Power BI certification preparation",
            "Strong placement network in analytics-focused companies",
        ],
        faqs: [
            { q: "Is this the same as Data Science?", a: "Business Analytics focuses on descriptive and diagnostic analysis using tools like Excel, SQL, and BI platforms. Data Science goes deeper into predictive modeling with programming. Both are valuable but serve different roles." },
            { q: "Do I need advanced math skills?", a: "Basic math and statistics concepts are covered in the program. You don't need advanced calculus or linear algebra — just a willingness to learn." },
            { q: "What tools will I learn?", a: "Excel (advanced), SQL, Power BI, Tableau, and Google Analytics. These are the most commonly requested tools in analytics job postings." },
        ],
    },
    {
        id: 9, slug: "cyber-security", name: "Cyber Security", duration: "6 Months", salary: "₹5-15 LPA",
        icon: "bi bi-shield-lock-fill", color: "rose", category: "technology",
        description: "Protect systems from threats with ethical hacking, network security, and compliance. Learn to defend organizations against evolving cyber threats.",
        tech: ["Ethical Hacking", "Network Security", "SIEM", "Firewalls", "Compliance"],
        outcomes: [
            "Conduct penetration testing and vulnerability assessments",
            "Implement network security measures and firewalls",
            "Analyze security incidents using SIEM tools",
            "Ensure compliance with GDPR, HIPAA, and PCI-DSS",
        ],
        jobRoles: ["Cyber Security Analyst", "Ethical Hacker", "Security Engineer", "SOC Analyst"],
        benefits: [
            "Learn offensive and defensive security techniques",
            "Practice in simulated cyber attack environments",
            "Industry certification preparation (CEH, CompTIA Security+)",
            "Critical shortage of cybersecurity professionals = high demand",
        ],
        faqs: [
            { q: "Is ethical hacking legal?", a: "Yes! Ethical hacking (penetration testing) is authorized testing of systems to find vulnerabilities before malicious hackers do. It's a legitimate and highly valued profession." },
            { q: "Do I need programming skills?", a: "Basic scripting knowledge (Python, Bash) is helpful. We include programming fundamentals needed for security automation and analysis." },
            { q: "What certifications will I be prepared for?", a: "The program prepares you for CEH (Certified Ethical Hacker), CompTIA Security+, and AWS Security Specialty certifications." },
        ],
    },
    {
        id: 10, slug: "embedded-systems", name: "Embedded Systems", duration: "5 Months", salary: "₹3.5-10 LPA",
        icon: "bi bi-cpu", color: "slate", category: "hardware",
        description: "Program microcontrollers and build IoT devices with C, C++, and Arduino. Learn to create the hardware-software bridge that powers smart devices.",
        tech: ["C", "C++", "Arduino", "Raspberry Pi", "IoT"],
        outcomes: [
            "Program microcontrollers using C and C++",
            "Build IoT devices with Arduino and Raspberry Pi",
            "Design sensor interfaces and communication protocols",
            "Develop firmware for embedded applications",
        ],
        jobRoles: ["Embedded Systems Engineer", "IoT Developer", "Firmware Engineer", "Hardware Software Engineer"],
        benefits: [
            "Hands-on lab sessions with real hardware kits",
            "Work with industry-standard microcontrollers and sensors",
            "Build a complete IoT project from concept to deployment",
            "Growing demand in automotive, healthcare, and smart home industries",
        ],
        faqs: [
            { q: "Do I need electronics knowledge?", a: "Basic electronics concepts are covered in the program. We start from the fundamentals of circuits and progressively build up to complex embedded systems." },
            { q: "What hardware will I work with?", a: "You'll work with Arduino boards, Raspberry Pi, ESP32, and various sensors and actuators. Hardware kits are provided as part of the program." },
            { q: "What industries hire embedded engineers?", a: "Automotive, aerospace, healthcare devices, consumer electronics, industrial automation, and IoT companies are the primary employers." },
        ],
    },
    {
        id: 11, slug: "vlsi", name: "VLSI", duration: "6 Months", salary: "₹4-12 LPA",
        icon: "bi bi-chip", color: "violet", category: "hardware",
        description: "Design and verify integrated circuits using Verilog, VHDL, and EDA tools. Enter the specialized world of chip design that powers all modern electronics.",
        tech: ["Verilog", "VHDL", "Cadence", "Synopsys", "Linux"],
        outcomes: [
            "Design digital circuits using Verilog and VHDL",
            "Perform functional verification and timing analysis",
            "Use EDA tools from Cadence and Synopsys",
            "Understand ASIC and FPGA design flows",
        ],
        jobRoles: ["VLSI Design Engineer", "Verification Engineer", "Physical Design Engineer", "FPGA Engineer"],
        benefits: [
            "Learn industry-standard EDA tools used by semiconductor companies",
            "Small batch size for personalized mentorship",
            "Strong placement network with top semiconductor firms",
            "Specialized skill with consistently high demand and salaries",
        ],
        faqs: [
            { q: "Do I need an electronics engineering background?", a: "A background in electronics or electrical engineering is recommended. The program builds on fundamentals of digital logic and circuit design." },
            { q: "Will I work on real chip designs?", a: "Yes, you'll work on project-based exercises that simulate real chip design workflows, including RTL design, verification, and synthesis." },
            { q: "Which companies hire VLSI engineers?", a: "Intel, Qualcomm, Samsung, TSMC, AMD, NVIDIA, Broadcom, and many Indian semiconductor companies are active recruiters." },
        ],
    },
    {
        id: 12, slug: "digital-marketing", name: "Digital Marketing", duration: "4 Months", salary: "₹3-8 LPA",
        icon: "bi bi-megaphone-fill", color: "pink", category: "business",
        description: "Master SEO, SEM, social media marketing, and Google Ads campaigns. Learn to drive traffic, generate leads, and grow businesses online.",
        tech: ["SEO", "Google Ads", "Social Media", "Analytics", "Content Marketing"],
        outcomes: [
            "Create and optimize Google Ads campaigns for maximum ROI",
            "Implement SEO strategies for organic traffic growth",
            "Manage social media marketing across platforms",
            "Analyze campaign performance with Google Analytics",
        ],
        jobRoles: ["Digital Marketing Specialist", "SEO Analyst", "PPC Manager", "Social Media Manager"],
        benefits: [
            "Work with real ad budgets for hands-on campaign experience",
            "Google Ads and Google Analytics certification preparation",
            "Portfolio of successful campaign case studies",
            "Freelancing opportunities available immediately after completion",
        ],
        faqs: [
            { q: "Do I need marketing experience?", a: "No prior marketing experience is needed. The program covers all fundamentals from scratch and builds up to advanced strategies." },
            { q: "Will I get to run real ad campaigns?", a: "Yes! We provide a training budget for Google Ads and Facebook Ads so you can gain hands-on experience with real campaigns." },
            { q: "Can I freelancing after this program?", a: "Absolutely! Digital marketing is one of the most freelancing-friendly fields. Many of our graduates start freelancing within weeks of completing the program." },
        ],
    },
    {
        id: 13, slug: "business-growth", name: "Business Growth Specialist", duration: "4 Months", salary: "₹4-10 LPA",
        icon: "bi bi-trophy-fill", color: "amber", category: "business",
        description: "100% Placement Guarantee or 100% Refund. Master business strategy and growth to become a sought-after business growth professional.",
        tech: ["Strategy", "Sales", "Marketing", "Leadership", "Growth Hacking"],
        highlight: true, badge: "100% Placement Guarantee",
        outcomes: [
            "Develop and execute business growth strategies",
            "Master sales funnels and conversion optimization",
            "Build and lead high-performing teams",
            "Apply growth hacking techniques for rapid scaling",
        ],
        jobRoles: ["Business Growth Manager", "Sales Manager", "Marketing Manager", "Business Development Lead"],
        benefits: [
            "100% Placement Guarantee or 100% Refund — zero risk",
            "Direct mentorship from successful entrepreneurs",
            "Real-world business strategy projects",
            "Networking opportunities with industry leaders",
        ],
        faqs: [
            { q: "What does 100% Placement Guarantee mean?", a: "If you complete the program and don't receive a job offer within 3 months, we refund 100% of your fees. That's our commitment to your success." },
            { q: "What background do I need?", a: "This program is open to graduates from any discipline. We value ambition and drive over specific educational backgrounds." },
            { q: "What kind of companies hire for these roles?", a: "Startups, SMEs, and large enterprises all need business growth professionals. Our hiring partners range from early-stage startups to established corporations." },
        ],
    },
    {
        id: 14, slug: "hr-management", name: "Human Resource Management", duration: "4 Months", salary: "₹3-8 LPA",
        icon: "bi bi-people-fill", color: "sky", category: "business",
        description: "HR operations, recruitment, payroll, and employee management systems. Learn to manage the most important asset of any organization — its people.",
        tech: ["HRIS", "Recruitment", "Payroll", "Labour Laws", "Performance Mgmt"],
        outcomes: [
            "Manage end-to-end recruitment and onboarding processes",
            "Administer payroll and employee benefits",
            "Ensure compliance with labor laws and regulations",
            "Implement performance management systems",
        ],
        jobRoles: ["HR Executive", "Recruitment Specialist", "HR Manager", "Talent Acquisition Specialist"],
        benefits: [
            "Comprehensive coverage of all HR functions",
            "Hands-on experience with popular HRIS platforms",
            "Understanding of Indian labor laws and compliance",
            "Strong demand across all industries and company sizes",
        ],
        faqs: [
            { q: "Is this suitable for fresh graduates?", a: "Yes! This program is designed for fresh graduates and early-career professionals looking to enter HR. We cover everything from basics to advanced practices." },
            { q: "What HR software will I learn?", a: "You'll work with popular HRIS platforms, ATS systems, and payroll software used by companies of all sizes." },
            { q: "What is the career growth in HR?", a: "HR professionals can grow from Executive → Manager → Director → VP → CHRO. The field offers excellent long-term career progression." },
        ],
    },
    {
        id: 15, slug: "cloud-computing", name: "Cloud Computing", duration: "6 Months", salary: "₹5-15 LPA",
        icon: "bi bi-cloud-fill", color: "blue", category: "technology",
        description: "AWS, Azure, GCP — architect and manage enterprise cloud infrastructure. Master the platforms that power 90% of the world's businesses.",
        tech: ["AWS", "Azure", "GCP", "Docker", "Terraform"],
        outcomes: [
            "Architect scalable solutions on AWS, Azure, and GCP",
            "Implement Infrastructure as Code with Terraform",
            "Manage cloud security and cost optimization",
            "Design high-availability and disaster recovery systems",
        ],
        jobRoles: ["Cloud Architect", "Cloud Engineer", "Solutions Architect", "Cloud DevOps Engineer"],
        benefits: [
            "Multi-cloud expertise across all three major platforms",
            "AWS Solutions Architect certification preparation",
            "Hands-on labs with real cloud infrastructure",
            "Cloud skills command premium salaries in the job market",
        ],
        faqs: [
            { q: "Which cloud platform is most important?", a: "AWS has the largest market share, so we focus primarily on it, but we cover Azure and GCP as well. Multi-cloud skills are increasingly valued by employers." },
            { q: "Do I need prior IT experience?", a: "Basic networking and operating system concepts are helpful. We include foundational modules, but some prior technical exposure will make the learning smoother." },
            { q: "What certifications will I be prepared for?", a: "AWS Solutions Architect Associate, Azure Fundamentals (AZ-900), and Google Cloud Associate Cloud Engineer certifications." },
        ],
    },
    {
        id: 16, slug: "ui-ux", name: "UI/UX", duration: "4 Months", salary: "₹3.5-10 LPA",
        icon: "bi bi-palette-fill", color: "fuchsia", category: "technology",
        description: "Design beautiful, user-friendly interfaces with Figma and design thinking. Learn to create digital experiences that users love.",
        tech: ["Figma", "Adobe XD", "Prototyping", "User Research", "Wireframing"],
        outcomes: [
            "Design responsive interfaces in Figma and Adobe XD",
            "Conduct user research and usability testing",
            "Create interactive prototypes and design systems",
            "Apply design thinking methodology to solve problems",
        ],
        jobRoles: ["UI/UX Designer", "Product Designer", "Interaction Designer", "UX Researcher"],
        benefits: [
            "Portfolio of 4+ professional design projects",
            "Learn the tools used by top design teams worldwide",
            "Bridge the gap between design and development",
            "High demand for UI/UX talent across all industries",
        ],
        faqs: [
            { q: "Do I need to be good at drawing?", a: "No! UI/UX design is about problem-solving and user experience, not artistic drawing. Digital design tools make it easy to create professional designs." },
            { q: "What's the difference between UI and UX?", a: "UX (User Experience) focuses on how a product works and feels, while UI (User Interface) focuses on the visual design. This program covers both." },
            { q: "Can I work freelance after this?", a: "Yes! UI/UX design is one of the most freelancing-friendly tech skills. Many designers work independently or start their own design studios." },
        ],
    },
    {
        id: 17, slug: "finance-tally", name: "Finance & Tally", duration: "4 Months", salary: "₹2.5-7 LPA",
        icon: "bi bi-calculator-fill", color: "green", category: "business",
        description: "Accounting, taxation, GST, and Tally ERP with practical exercises. Master the financial skills every business needs.",
        tech: ["Tally", "GST", "Income Tax", "Accounting", "Excel"],
        outcomes: [
            "Manage complete accounting cycles with Tally ERP",
            "File GST returns and manage tax compliance",
            "Handle income tax calculations and filings",
            "Generate financial reports and statements",
        ],
        jobRoles: ["Accountant", "Tally Operator", "Tax Consultant", "Finance Executive"],
        benefits: [
            "Practical training with real business accounting scenarios",
            "TallyPrime certification preparation",
            "GST and income tax filing experience",
            "Essential skills for every business — guaranteed demand",
        ],
        faqs: [
            { q: "Do I need a commerce background?", a: "While a commerce background helps, it's not mandatory. We cover accounting fundamentals and progressively build up to advanced topics." },
            { q: "Which version of Tally will I learn?", a: "We teach TallyPrime, the latest version, along with GST integration and advanced features used in modern businesses." },
            { q: "Can I start my own accounting practice?", a: "Yes! After completing the program, you can offer accounting, tax filing, and GST services to small businesses. Many graduates start their own practices." },
        ],
    },
    {
        id: 18, slug: "medical-coding", name: "Medical Coding", duration: "4 Months", salary: "₹3-8 LPA",
        icon: "bi bi-heart-pulse-fill", color: "red", category: "technology",
        description: "ICD-10, CPT, HIPAA compliance, and healthcare data management. Enter the growing field of healthcare information management.",
        tech: ["ICD-10", "CPT", "HIPAA", "Medical Terminology", "AHIMA"],
        outcomes: [
            "Assign accurate medical codes using ICD-10 and CPT",
            "Ensure HIPAA compliance in healthcare data handling",
            "Understand medical terminology and anatomy basics",
            "Process medical claims and billing accurately",
        ],
        jobRoles: ["Medical Coder", "Health Information Technician", "Medical Billing Specialist", "Coding Auditor"],
        benefits: [
            "CPC (Certified Professional Coder) exam preparation",
            "Work from home opportunities in healthcare industry",
            "Growing demand due to healthcare digitization",
            "Stable career with consistent industry growth",
        ],
        faqs: [
            { q: "Do I need a medical background?", a: "No medical background is required. We teach medical terminology and anatomy fundamentals needed for coding. However, attention to detail is essential." },
            { q: "What certifications are available?", a: "The program prepares you for CPC (AAPC) and CCS (AHIMA) certifications, the two most recognized credentials in medical coding." },
            { q: "Can I work from home?", a: "Yes! Medical coding is one of the most remote-friendly healthcare professions. Many companies offer work-from-home positions for experienced coders." },
        ],
    },
];

const program = computed(() => {
    return programs.find((p) => p.slug === route.params.slug) || null;
});

const relatedPrograms = computed(() => {
    if (!program.value) return [];
    return programs
        .filter((p) => p.id !== program.value.id)
        .slice(0, 5);
});

const colorMap = {
    blue: { hero: "from-blue-600 via-blue-700 to-indigo-800", icon: "bg-gradient-to-br from-blue-500 to-indigo-600", text: "text-blue-600", techBadge: "bg-blue-50 text-blue-700 border-blue-100" },
    purple: { hero: "from-purple-600 via-purple-700 to-violet-800", icon: "bg-gradient-to-br from-purple-500 to-violet-600", text: "text-purple-600", techBadge: "bg-purple-50 text-purple-700 border-purple-100" },
    emerald: { hero: "from-emerald-600 via-emerald-700 to-teal-800", icon: "bg-gradient-to-br from-emerald-500 to-teal-600", text: "text-emerald-600", techBadge: "bg-emerald-50 text-emerald-700 border-emerald-100" },
    cyan: { hero: "from-cyan-600 via-cyan-700 to-blue-800", icon: "bg-gradient-to-br from-cyan-500 to-blue-600", text: "text-cyan-600", techBadge: "bg-cyan-50 text-cyan-700 border-cyan-100" },
    red: { hero: "from-red-600 via-red-700 to-rose-800", icon: "bg-gradient-to-br from-red-500 to-rose-600", text: "text-red-600", techBadge: "bg-red-50 text-red-700 border-red-100" },
    amber: { hero: "from-amber-600 via-amber-700 to-orange-800", icon: "bg-gradient-to-br from-amber-500 to-orange-600", text: "text-amber-600", techBadge: "bg-amber-50 text-amber-700 border-amber-100" },
    indigo: { hero: "from-indigo-600 via-indigo-700 to-blue-800", icon: "bg-gradient-to-br from-indigo-500 to-blue-600", text: "text-indigo-600", techBadge: "bg-indigo-50 text-indigo-700 border-indigo-100" },
    teal: { hero: "from-teal-600 via-teal-700 to-cyan-800", icon: "bg-gradient-to-br from-teal-500 to-cyan-600", text: "text-teal-600", techBadge: "bg-teal-50 text-teal-700 border-teal-100" },
    rose: { hero: "from-rose-600 via-rose-700 to-pink-800", icon: "bg-gradient-to-br from-rose-500 to-pink-600", text: "text-rose-600", techBadge: "bg-rose-50 text-rose-700 border-rose-100" },
    slate: { hero: "from-slate-600 via-slate-700 to-gray-800", icon: "bg-gradient-to-br from-slate-500 to-gray-600", text: "text-slate-600", techBadge: "bg-slate-50 text-slate-700 border-slate-100" },
    violet: { hero: "from-violet-600 via-violet-700 to-purple-800", icon: "bg-gradient-to-br from-violet-500 to-purple-600", text: "text-violet-600", techBadge: "bg-violet-50 text-violet-700 border-violet-100" },
    pink: { hero: "from-pink-600 via-pink-700 to-rose-800", icon: "bg-gradient-to-br from-pink-500 to-rose-600", text: "text-pink-600", techBadge: "bg-pink-50 text-pink-700 border-pink-100" },
    sky: { hero: "from-sky-600 via-sky-700 to-blue-800", icon: "bg-gradient-to-br from-sky-500 to-blue-600", text: "text-sky-600", techBadge: "bg-sky-50 text-sky-700 border-sky-100" },
    fuchsia: { hero: "from-fuchsia-600 via-fuchsia-700 to-purple-800", icon: "bg-gradient-to-br from-fuchsia-500 to-purple-600", text: "text-fuchsia-600", techBadge: "bg-fuchsia-50 text-fuchsia-700 border-fuchsia-100" },
    green: { hero: "from-green-600 via-green-700 to-emerald-800", icon: "bg-gradient-to-br from-green-500 to-emerald-600", text: "text-green-600", techBadge: "bg-green-50 text-green-700 border-green-100" },
};

const getColors = (color) => colorMap[color] || colorMap.blue;

const heroGradient = computed(() => program.value ? `bg-gradient-to-r ${getColors(program.value.color).hero}` : "");
const iconBg = computed(() => program.value ? getColors(program.value.color).icon : "");
const textColor = computed(() => program.value ? getColors(program.value.color).text : "");
const techBadgeClasses = computed(() => program.value ? getColors(program.value.color).techBadge : "");

const getIconBg = (color) => getColors(color).icon;

const toggleFaq = (idx) => {
    openFaq.value = openFaq.value === idx ? null : idx;
};

onMounted(() => {
    window.scrollTo(0, 0);
});
</script>
