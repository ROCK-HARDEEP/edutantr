<template>
    <section class="w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left: Header -->
            <div class="lg:col-span-5">
                <SectionHeader
                    :eyebrow="$t('FAQ')"
                    icon="bi bi-question-circle-fill"
                    :center="false"
                    :subtitle="$t('Got questions? We\'ve got answers. Find everything you need to know about our training programs.')"
                >
                    <template #title>
                        {{ $t('Frequently Asked') }}
                        <span class="accent">{{ $t('Questions') }}</span>
                    </template>
                </SectionHeader>
            </div>

            <!-- Right: Accordion -->
            <div class="lg:col-span-7">
                <Accordion :activeIndex="0" class="faq-prime-accordion">
                    <AccordionPanel
                        v-for="(item, index) in faqItems"
                        :key="index"
                        :value="index"
                        class="faq-panel mb-3"
                    >
                        <AccordionHeader class="faq-header">
                            <span class="flex items-center gap-3">
                                <i :class="item.icon" class="text-primary-600 text-lg"></i>
                                {{ item.question }}
                            </span>
                        </AccordionHeader>
                        <AccordionContent class="faq-content">
                            <div v-html="item.answer"></div>
                        </AccordionContent>
                    </AccordionPanel>
                </Accordion>
            </div>
        </div>
    </section>
</template>

<script setup>
import SectionHeader from "./landing/SectionHeader.vue";
import Accordion from "primevue/accordion";
import AccordionPanel from "primevue/accordionpanel";
import AccordionHeader from "primevue/accordionheader";
import AccordionContent from "primevue/accordioncontent";

const faqItems = [
    {
        question: "What courses does Edutantr offer?",
        icon: "bi bi-book-fill",
        answer: "We offer structured training programs in <strong>Full-Stack Web Development</strong>, <strong>Data Science & AI</strong>, <strong>Cloud Computing (AWS)</strong>, <strong>DevOps</strong>, <strong>UI/UX Design</strong>, and <strong>Mobile App Development</strong>. Each program is designed to take you from beginner to job-ready in 5-6 months.",
    },
    {
        question: "Do I need prior coding experience to enroll?",
        icon: "bi bi-person-fill-check",
        answer: "No! Our programs are designed for <strong>complete beginners</strong>. We start from the fundamentals and gradually build up to advanced concepts. Our mentors guide you through every step, and you'll work on real projects from day one.",
    },
    {
        question: "How are the classes conducted — online or offline?",
        icon: "bi bi-laptop-fill",
        answer: "We offer <strong>live online classes</strong> conducted by industry experts. All sessions are interactive — you can ask questions in real-time, participate in coding exercises, and get instant feedback. Recordings are available for review.",
    },
    {
        question: "What is the placement assistance?",
        icon: "bi bi-briefcase-fill",
        answer: "Our dedicated placement cell works with <strong>200+ partner companies</strong> including TCS, Infosys, Wipro, HCL, and MNCs like Google, Microsoft, and Amazon. We provide <strong>resume building, mock interviews, portfolio optimization, and direct referrals</strong> to hiring managers.",
    },
    {
        question: "What is the course fee and are there EMI options?",
        icon: "bi bi-credit-card-fill",
        answer: "Course fees range from <strong>₹15,000 to ₹60,000</strong> depending on the program. We offer flexible <strong>EMI options</strong> starting at ₹2,500/month through our banking partners. Scholarships are available for deserving students.",
    },
    {
        question: "Will I get a certificate after course completion?",
        icon: "bi bi-award-fill",
        answer: "Yes! Upon successful completion, you receive an <strong>Edutantr Industry-Recognized Certificate</strong>. We also help you prepare for <strong>certifications from AWS, Google, Microsoft</strong>, and other tech giants that boost your resume.",
    },
    {
        question: "What if I miss a class or fall behind?",
        icon: "bi bi-clock-fill",
        answer: "All live sessions are <strong>recorded and available on-demand</strong>. If you miss a class, you can watch the recording and catch up. Our mentors also offer <strong>1-on-1 doubt-clearing sessions</strong> to help you stay on track.",
    },
    {
        question: "How is Edutantr different from other online platforms?",
        icon: "bi bi-star-fill",
        answer: "Unlike pre-recorded platforms, we offer <strong>live interactive training</strong> with industry mentors, <strong>real-world projects</strong>, <strong>guaranteed placement assistance</strong>, and a <strong>structured career path</strong> — not just random courses. Our students get hired, not just certified.",
    },
];
</script>

<style>
.faq-prime-accordion .faq-panel {
    border: 1px solid #e2e8f0;
    border-radius: 16px !important;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    transition: box-shadow 0.25s ease;
}

.faq-prime-accordion .faq-panel:hover {
    box-shadow: 0 8px 24px rgba(48, 108, 60, 0.08);
}

.faq-prime-accordion .faq-header {
    padding: 1.15rem 1.35rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #0f172a;
    background: #fff;
}

.faq-prime-accordion .faq-panel[data-p-state="open"] .faq-header {
    background: linear-gradient(135deg, rgba(220, 252, 231, 0.5), rgba(240, 253, 244, 0.8));
    color: #15803d;
}

.faq-prime-accordion .faq-content > div {
    padding: 0 1.35rem 1.25rem;
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.65;
}

.faq-prime-accordion .faq-content strong {
    color: #0f172a;
}
</style>
