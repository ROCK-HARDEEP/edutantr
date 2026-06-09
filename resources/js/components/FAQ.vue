<template>
    <section class="faq-section">
        <div class="row g-4 g-lg-5 align-items-start">
            <div class="col-lg-5">
                <SectionHeader
                    :eyebrow="$t('FAQ')"
                    icon="bi bi-question-circle-fill"
                    :center="false"
                    :subtitle="$t('Find quick answers to common questions about courses, accounts, and learning with us.')"
                >
                    <template #title>
                        {{ $t('Frequently Asked') }}
                        <span class="accent">{{ $t('Questions') }}</span>
                    </template>
                </SectionHeader>
                <router-link to="/page/faq" class="btn btn-outline-primary rounded-pill px-4 fw-semibold faq-more-btn">
                    {{ $t('Read More') }}
                    <i class="bi bi-arrow-right ms-2"></i>
                </router-link>
            </div>

            <div class="col-lg-7">
                <div class="accordion faq-accordion" id="accordionFlushExample">
                    <div
                        v-for="(item, index) in faqItems"
                        :key="index"
                        class="accordion-item faq-item"
                    >
                        <h2 class="accordion-header" :id="'flush-heading' + index">
                            <button
                                class="accordion-button fw-semibold"
                                :class="{ collapsed: index !== 0 }"
                                type="button"
                                data-bs-toggle="collapse"
                                :data-bs-target="'#flush-collapse' + index"
                                :aria-expanded="index === 0"
                                :aria-controls="'flush-collapse' + index"
                            >
                                {{ item.question }}
                            </button>
                        </h2>
                        <div
                            :id="'flush-collapse' + index"
                            class="accordion-collapse collapse"
                            :class="{ show: index === 0 }"
                            :aria-labelledby="'flush-heading' + index"
                            data-bs-parent="#accordionFlushExample"
                        >
                            <div class="accordion-body" v-html="item.answer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.faq-more-btn {
    border-width: 2px;
    transition: all 0.25s ease;

    &:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(48, 108, 60, 0.2);
    }
}

.faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}

.faq-item {
    border: 1px solid #e2e8f0;
    border-radius: 16px !important;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    transition: box-shadow 0.25s ease;

    &:hover {
        box-shadow: 0 8px 24px rgba(48, 108, 60, 0.08);
    }

    .accordion-button {
        padding: 1.15rem 1.35rem;
        font-size: 0.95rem;
        color: #0f172a;
        background: #fff;
        box-shadow: none;

        &:not(.collapsed) {
            background: linear-gradient(135deg, rgba(220, 252, 231, 0.5), rgba(240, 253, 244, 0.8));
            color: #15803d;
        }

        &::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%2315803d'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }
    }

    .accordion-body {
        padding: 0 1.35rem 1.25rem;
        color: #64748b;
        font-size: 0.9rem;
        line-height: 1.65;
    }
}
</style>

<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";
import SectionHeader from "./landing/SectionHeader.vue";

const { t } = useI18n();

const faqItems = computed(() => [
    {
        question: t("How to delete my account") + "?",
        answer: t("To delete your account permanently, please contact our support team and request account deletion. Once verified, your account and all associated data will be removed. This action is irreversible."),
    },
    {
        question: t("How can I deactivate my account") + "?",
        answer: t('You can temporarily deactivate your account from Account Settings. Navigate to Privacy & Security and click "Deactivate Account." Your profile will be hidden while deactivated.'),
    },
    {
        question: t("How can I reactive my account") + "?",
        answer: t("To reactivate your account, simply log back in using your email and password. Your account will be restored with all your previous data and progress intact."),
    },
    {
        question: t("What happens to my course progress if I deactivate my account") + "?",
        answer: t("Your course progress is safely stored even if you deactivate your account. Once you reactivate or log back in, you can continue from where you left off."),
    },
]);
</script>
