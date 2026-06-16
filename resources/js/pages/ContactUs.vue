<template>
    <div class="min-h-screen bg-slate-50">
        <!-- Hero/Header Section -->
        <section class="relative pt-32 pb-24 bg-slate-900 overflow-hidden">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(circle at 50% 0%, rgba(249,115,22,0.15) 0%, transparent 70%);"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-400 text-sm font-semibold tracking-wide mb-6">
                    <i class="bi bi-headset"></i> {{ $t("We're Here to Help") }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight" style="font-family: 'Lexend', sans-serif;">
                    {{ $t('Get in') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">{{ $t('Touch') }}</span>
                </h1>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto font-light leading-relaxed">
                    {{ $t('Have questions about our programs, corporate training, or placement support? Our team is ready to help you launch your tech career.') }}
                </p>
            </div>
        </section>

        <!-- Contact Cards & Form -->
        <section class="py-16 -mt-16 relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Contact Info Cards -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Card 1: Phone -->
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col items-start gap-4 transition-transform duration-300 hover:-translate-y-1">
                            <div class="w-14 h-14 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-2xl mb-2">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $t('Call Us') }}</h3>
                                <p class="text-sm text-slate-500 mb-3">{{ $t('Mon-Fri from 9am to 6pm.') }}</p>
                                <a :href="`tel:${masterStore.masterData?.footer_contact}`" class="text-lg font-semibold text-orange-600 hover:text-orange-700 transition-colors">
                                    {{ masterStore.masterData?.footer_contact || '+91 00000 00000' }}
                                </a>
                            </div>
                        </div>
                        
                        <!-- Card 2: Email -->
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col items-start gap-4 transition-transform duration-300 hover:-translate-y-1">
                            <div class="w-14 h-14 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl mb-2">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $t('Email Us') }}</h3>
                                <p class="text-sm text-slate-500 mb-3">{{ $t('We usually respond within 24 hours.') }}</p>
                                <a :href="`mailto:${masterStore.masterData?.footer_email}`" class="text-lg font-semibold text-cyan-600 hover:text-cyan-700 transition-colors">
                                    {{ masterStore.masterData?.footer_email || 'hello@edutantr.com' }}
                                </a>
                            </div>
                        </div>

                        <!-- Card 3: Location -->
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col items-start gap-4 transition-transform duration-300 hover:-translate-y-1">
                            <div class="w-14 h-14 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-2">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $t('Visit Us') }}</h3>
                                <p class="text-sm text-slate-500 mb-3">{{ $t('Drop by our headquarters.') }}</p>
                                <p class="text-base font-medium text-slate-700 leading-relaxed">
                                    {{ headOfficeAddress }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 p-8 md:p-12 border border-slate-100 h-full flex flex-col justify-center">
                            <div class="mb-8">
                                <h2 class="text-3xl font-extrabold text-slate-900 mb-2" style="font-family: 'Lexend', sans-serif;">{{ $t('Send a Message') }}</h2>
                                <p class="text-slate-500">{{ $t('Fill out the form below and our placement experts will get back to you shortly.') }}</p>
                            </div>

                            <form @submit.prevent="submitForm" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-700">{{ $t('Full Name') }} *</label>
                                        <InputText v-model="form.name" class="w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all" :placeholder="$t('John Doe')" required />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-700">{{ $t('Email Address') }} *</label>
                                        <InputText v-model="form.email" type="email" class="w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all" :placeholder="$t('john@example.com')" required />
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">{{ $t('Subject') }} *</label>
                                    <InputText v-model="form.subject" class="w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all" :placeholder="$t('How can we help?')" required />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">{{ $t('Message') }} *</label>
                                    <Textarea v-model="form.message" rows="5" class="w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all" :placeholder="$t('Tell us more about your inquiry...')" required />
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(249,115,22,0.3)] hover:-translate-y-0.5 hover:shadow-[0_0_30px_rgba(249,115,22,0.5)] transition-all duration-300">
                                        <i class="bi bi-send-fill mr-2"></i> {{ $t('Send Message') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us (Replaced Learning Offers) -->
        <section class="py-16 md:py-24 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight" style="font-family: 'Lexend', sans-serif;">{{ offersTitle }}</h2>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto">{{ offersDescription }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="(offer, idx) in learningOffers" :key="idx" class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div :class="['w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm border border-black/5', offer.bgClass, offer.iconClass]">
                            <i :class="offer.icon"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ offer.title }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ offer.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Optional Map Section -->
        <section v-if="googleMapEmbed" class="py-12 border-t border-slate-100 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-2.5 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                    <div class="rounded-[1.5rem] overflow-hidden [&>iframe]:w-full [&>iframe]:h-[450px]" v-html="googleMapEmbed"></div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import BrandLogo from "@/components/BrandLogo.vue";
import { computed, onMounted, ref } from "vue";
import Swal from "sweetalert2";
import { useMasterStore } from "@/stores/master";
import axios from "axios";
import { useI18n } from "vue-i18n";

// PrimeVue components
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Button from "primevue/button";

const { t } = useI18n();
const masterStore = useMasterStore();

const form = ref({
    name: "",
    email: "",
    subject: "",
    message: "",
});

const offersTitle = computed(() => {
    return (
        masterStore.masterData?.contact_offers_title ||
        t("Why Partner With Us?")
    );
});

const offersDescription = computed(() => {
    return (
        masterStore.masterData?.contact_offers_description ||
        t("Discover how our specialized tech training and robust placement cell can catapult your career to the next level.")
    );
});

const offersIcon = computed(() => {
    return masterStore.masterData?.contact_offers_icon || "pi pi-graduation-cap";
});

const offersHeaderImage = computed(() => {
    return masterStore.masterData?.contact_offers_image || "";
});

const headOfficeAddress = computed(() => {
    return (
        masterStore.masterData?.head_office_address ||
        masterStore.masterData?.footer_description ||
        t("Our head office address will be updated soon. Please contact us by phone or email.")
    );
});

const googleMapEmbed = computed(() => {
    const embedCode = masterStore.masterData?.google_map?.trim();
    return embedCode || "";
});

const learningOffers = computed(() => [
    {
        icon: "bi bi-briefcase-fill",
        iconClass: "text-orange-600",
        bgClass: "bg-orange-100",
        title: t("100% Placement Assistance"),
        description: t("We don't just teach. We ensure you land a top-tier job with our dedicated placement cell."),
    },
    {
        icon: "bi bi-person-workspace",
        iconClass: "text-cyan-600",
        bgClass: "bg-cyan-100",
        title: t("Expert Industry Mentors"),
        description: t("Learn directly from professionals working at product-based tech companies."),
    },
    {
        icon: "bi bi-code-slash",
        iconClass: "text-purple-600",
        bgClass: "bg-purple-100",
        title: t("Real-World Projects"),
        description: t("Build a robust portfolio by working on live projects that mirror industry demands."),
    },
    {
        icon: "bi bi-award-fill",
        iconClass: "text-emerald-600",
        bgClass: "bg-emerald-100",
        title: t("Recognized Certification"),
        description: t("Earn credentials that hold weight and instantly boost your resume's value."),
    },
    {
        icon: "bi bi-people-fill",
        iconClass: "text-blue-600",
        bgClass: "bg-blue-100",
        title: t("Mock Interviews"),
        description: t("Practice with HR experts and technical leads to conquer real interviews with confidence."),
    },
    {
        icon: "bi bi-shield-check",
        iconClass: "text-rose-600",
        bgClass: "bg-rose-100",
        title: t("Lifetime Career Support"),
        description: t("Gain lifelong access to our alumni network, exclusive job boards, and career coaching."),
    },
]);

const resetForm = () => {
    form.value = { name: "", email: "", subject: "", message: "" };
};

onMounted(async () => {
    if (masterStore.masterData?.google_map) {
        return;
    }

    try {
        const response = await axios.get("/master", {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });
        masterStore.setMasterData(response.data.data.master);
    } catch (error) {
        console.error("Error fetching master data:", error);
    }
});

const submitForm = async () => {
    try {
        const response = await axios.post(`/contact/submit`, form.value, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });

        if (response.status === 201) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: t("Your inquiry has been submitted"),
                showConfirmButton: false,
                timer: 1500,
                customClass: { title: "swal-title" },
            });
            resetForm();
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: `Error submitting form:, ${error.response?.data?.message}`,
            showConfirmButton: false,
            timer: 3500,
            customClass: { title: "swal-title" },
        });
        console.error("Error submitting form:", error);
    }
};
</script>

<style scoped>
:deep(.p-inputtext),
:deep(.p-textarea) {
    width: 100%;
}

:deep(.p-button) {
    background: var(--color-primary-600);
    border-color: var(--color-primary-600);
}

:deep(.p-button:hover) {
    background: var(--color-primary-700);
    border-color: var(--color-primary-700);
}
</style>
