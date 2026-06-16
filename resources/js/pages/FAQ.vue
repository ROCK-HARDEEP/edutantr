<template>
    <section class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                <!-- Left Content -->
                <div class="lg:sticky lg:top-28">
                    <span class="inline-block text-primary-600 font-bold mb-3 tracking-wide uppercase text-sm">
                        {{ $t('Find Your Answers') }}
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-navy mb-2">
                        {{ $t('Have any thought') }}?
                    </h2>
                    <h2 class="text-3xl md:text-4xl font-bold text-navy mb-5">
                        {{ $t('Look here') }}.
                    </h2>
                    <p class="text-slate leading-relaxed mb-8 max-w-md">
                        {{ $t('Completely plagiarize fully researched collaboration and idea-sharing for covalent') }}.
                    </p>
                    <router-link
                        to="/page/faq"
                        class="inline-flex items-center gap-2 px-6 py-3 border-2 border-primary-600 text-primary-700 font-semibold rounded-full hover:bg-primary-600 hover:text-white transition-all duration-300"
                    >
                        {{ $t('Read More') }}
                        <i class="pi pi-arrow-right"></i>
                    </router-link>
                </div>

                <!-- Right Accordion -->
                <div>
                    <Accordion :multiple="true" :activeIndex="[0]">
                        <AccordionPanel v-for="(faq, index) in faqs" :key="index" :value="index">
                            <AccordionHeader class="font-semibold">
                                {{ faq.question }}
                            </AccordionHeader>
                            <AccordionContent>
                                <p class="text-slate leading-relaxed m-0">
                                    {{ faq.answer }}
                                </p>
                            </AccordionContent>
                        </AccordionPanel>
                    </Accordion>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted } from "vue";
import { useI18n } from "vue-i18n";

// PrimeVue Accordion components
import Accordion from "primevue/accordion";
import AccordionPanel from "primevue/accordionpanel";
import AccordionHeader from "primevue/accordionheader";
import AccordionContent from "primevue/accordioncontent";

const { t } = useI18n();

const faqs = [
    {
        question: t("How to delete my account") + "?",
        answer: "To delete your account permanently, please contact our support team and request account deletion. Once verified, your account and all associated data will be removed from our system. Please note, this action is irreversible.",
    },
    {
        question: t("How can I deactivate my account") + "?",
        answer: 'You can temporarily deactivate your account from the Account Settings page. Simply navigate to the Privacy & Security section and click on "Deactivate Account." While your account is deactivated, your profile will be hidden, and you won\'t receive any notifications.',
    },
    {
        question: t("How can I reactive my account") + "?",
        answer: "To reactivate your account, simply log back in using your email and password. Your account will be restored with all your previous data and progress intact. If you face any issues, feel free to reach out to our support team.",
    },
    {
        question: t("What happens to my course progress if I deactivate my account") + "?",
        answer: "Your course progress is safely stored even if you deactivate your account. Once you reactivate or log back in, you can continue from where you left off without losing any data.",
    },
];

onMounted(() => {
    window.scrollTo(0, 0);
});
</script>

<style scoped>
:deep(.p-accordion) {
    background: transparent;
}

:deep(.p-accordion-panel) {
    border: none;
    margin-bottom: 12px;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    background: white;
    border: 1px solid #e2e8f0;
}

:deep(.p-accordion-header) {
    padding: 1rem 1.25rem;
    font-weight: 600;
    color: var(--color-navy);
}

:deep(.p-accordion-content) {
    padding: 0 1.25rem 1.25rem;
    background: transparent;
    border: none;
}

:deep(.p-accordion-header-link) {
    border-radius: 14px;
    padding: 1rem 1.25rem;
}

:deep(.p-accordion-header-link:hover) {
    background: var(--color-primary-50);
}

:deep(.p-accordion-toggle-icon) {
    color: var(--color-primary-600);
}
</style>
