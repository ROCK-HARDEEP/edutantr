<template>
    <div class="contact-page">
        <!-- Our Best Learning Offers -->
        <section class="py-5 contact-page__offers">
            <div class="container">
                

                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8 contact-offers-intro">
                        <div v-if="offersHeaderImage" class="contact-offers-intro__media mb-3">
                            <img :src="offersHeaderImage" :alt="offersTitle" />
                        </div>
                        <div v-else-if="offersIcon" class="contact-offers-intro__icon mb-3">
                            <i :class="offersIcon" aria-hidden="true"></i>
                        </div>
                        <h1 class="fw-bold display-5 text-dark">{{ offersTitle }}</h1>
                        <p v-if="offersDescription" class="text-muted lead contact-offers-intro__desc">
                            {{ offersDescription }}
                        </p>
                        <hr class="w-25 mx-auto border-3 border-primary" />
                    </div>
                </div>

                <div class="row g-4">
                    <div v-for="offer in learningOffers" :key="offer.title" class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4 text-center p-4 hover-highlight">
                            <div :class="['fs-1 mb-3', offer.colorClass]">
                                <i :class="offer.icon"></i>
                            </div>
                            <h5 class="fw-bold">{{ offer.title }}</h5>
                            <p class="text-muted mb-0">{{ offer.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Head Office & Contact -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row g-4 g-xl-5 align-items-start">
                    <div class="col-lg-5">
                        <div class="head-office-card h-100">
                            <span class="head-office-card__badge">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $t('Head Office Address') }}
                            </span>
                            <h2 class="head-office-card__title fw-bold">
                                {{ $t('Get in Touch With Us') }}
                            </h2>
                            <p class="head-office-card__address text-muted">
                                {{ headOfficeAddress }}
                            </p>

                            <ul class="list-unstyled head-office-card__contacts mb-0">
                                <li v-if="masterStore?.masterData?.footer_contact">
                                    <a :href="`tel:${masterStore.masterData.footer_contact}`" class="head-office-card__link">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span>{{ masterStore.masterData.footer_contact }}</span>
                                    </a>
                                </li>
                                <li v-if="masterStore?.masterData?.footer_email">
                                    <a
                                        :href="`mailto:${masterStore.masterData.footer_email}`"
                                        class="head-office-card__link"
                                    >
                                        <i class="bi bi-envelope-fill"></i>
                                        <span>{{ masterStore.masterData.footer_email }}</span>
                                    </a>
                                </li>
                                <li v-if="masterStore?.masterData?.whatsapp_support_number">
                                    <a
                                        :href="masterStore.masterData.whatsapp_support_number"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="head-office-card__link"
                                    >
                                        <i class="bi bi-whatsapp"></i>
                                        <span>{{ masterStore.masterData.whatsapp_contact_us || $t('WhatsApp Support') }}</span>
                                    </a>
                                </li>
                            </ul>

                            <div
                                v-if="masterStore?.masterData?.footer_social_icons?.length"
                                class="head-office-card__social d-flex flex-wrap gap-2 mt-4"
                            >
                                <a
                                    v-for="social in masterStore.masterData.footer_social_icons"
                                    :key="social.url"
                                    :href="social.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                >
                                    <i :class="social.icon"></i>
                                    {{ social.title }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                            <div class="text-center mb-4">
                                <BrandLogo to="/" centered size="lg" />
                                <h4 class="fw-bold mt-3 mb-1">{{ $t('Connect with us') }}!!</h4>
                                <p class="text-muted small mb-0">{{ $t("We'd love to hear from you") }}</p>
                            </div>

                            <form @submit.prevent="submitForm">
                                <div class="row g-3">
                                    <div class="col-md-6 form-floating">
                                        <input
                                            id="contactName"
                                            v-model="form.name"
                                            type="text"
                                            class="form-control"
                                            :placeholder="$t('Full Name')"
                                            required
                                        />
                                        <label for="contactName">{{ $t('Full Name') }} *</label>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <input
                                            id="contactEmail"
                                            v-model="form.email"
                                            type="email"
                                            class="form-control"
                                            :placeholder="$t('Email')"
                                            required
                                        />
                                        <label for="contactEmail">{{ $t('Email') }} *</label>
                                    </div>
                                    <div class="col-12 form-floating">
                                        <input
                                            id="contactSubject"
                                            v-model="form.subject"
                                            type="text"
                                            class="form-control"
                                            :placeholder="$t('Subject')"
                                            required
                                        />
                                        <label for="contactSubject">{{ $t('Subject') }} *</label>
                                    </div>
                                    <div class="col-12 form-floating">
                                        <textarea
                                            id="contactMessage"
                                            v-model="form.message"
                                            class="form-control"
                                            :placeholder="$t('Message')"
                                            rows="5"
                                            style="height: 140px"
                                            required
                                        ></textarea>
                                        <label for="contactMessage">{{ $t('Message') }} *</label>
                                    </div>
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                            {{ $t('Connect Now') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div v-if="googleMapEmbed" class="row justify-content-center mt-5">
                    <div class="col-12">
                        <div class="map-embed shadow rounded-4 overflow-hidden">
                            <div v-html="googleMapEmbed" class="map-embed__frame"></div>
                        </div>
                    </div>
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
        t("Our Best Learning Offers")
    );
});

const offersDescription = computed(() => {
    return (
        masterStore.masterData?.contact_offers_description ||
        t("Discover the most effective way to learn with expert mentors, real-world projects, and certifications that matter.")
    );
});

const offersIcon = computed(() => {
    return masterStore.masterData?.contact_offers_icon || "bi bi-mortarboard-fill";
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
        icon: "bi bi-easel2-fill",
        colorClass: "text-primary",
        title: t("Expert Instructors"),
        description: t("Learn directly from industry experts with years of real-world experience."),
    },
    {
        icon: "bi bi-award-fill",
        colorClass: "text-success",
        title: t("Certification Programs"),
        description: t("Earn globally recognized certificates to showcase your expertise."),
    },
    {
        icon: "bi bi-code-slash",
        colorClass: "text-warning",
        title: t("Hands-on Projects"),
        description: t("Build real projects and gain practical experience while learning."),
    },
    {
        icon: "bi bi-people",
        colorClass: "text-danger",
        title: t("Community & Mentorship"),
        description: t("Join a supportive community and get personalized mentorship."),
    },
    {
        icon: "bi bi-clock-fill",
        colorClass: "text-info",
        title: t("Flexible Learning"),
        description: t("Study at your own pace, anytime and anywhere, without restrictions."),
    },
    {
        icon: "bi bi-shield-check",
        colorClass: "text-purple",
        title: t("Verified Certificates"),
        description: t("Earn officially recognized credentials to boost your career profile."),
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
.contact-page__offers {
    background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
}

.contact-offers-intro__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ecfdf5, #dcfce7);
    color: #15803d;
    font-size: 2rem;
    margin-left: auto;
    margin-right: auto;
}

.contact-offers-intro__media img {
    max-height: 88px;
    width: auto;
    object-fit: contain;
    border-radius: 12px;
}

.contact-offers-intro__desc {
    white-space: pre-line;
}

.head-office-card__address {
    white-space: pre-line;
}

.hover-highlight {
    transition: 0.3s ease-in-out;
}

.hover-highlight:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15) !important;
}

.text-purple {
    color: #6f42c1;
}

.head-office-card {
    background: #fff;
    border-radius: 24px;
    padding: 2rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
}

.head-office-card__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.9rem;
    border-radius: 50px;
    background: #ecfdf5;
    color: #15803d;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.head-office-card__title {
    font-size: clamp(1.5rem, 3vw, 2rem);
    color: #0f172a;
    margin-bottom: 1rem;
}

.head-office-card__address {
    line-height: 1.7;
    margin-bottom: 1.5rem;
    white-space: pre-line;
}

.head-office-card__contacts li + li {
    margin-top: 0.85rem;
}

.head-office-card__link {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    color: #334155;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;

    i {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f0fdf4;
        color: #16a34a;
        flex-shrink: 0;
    }

    &:hover {
        color: #15803d;
    }
}

.map-embed {
    background: #fff;
    border: 1px solid #e2e8f0;
}

.map-embed__frame {
    position: relative;
    width: 100%;
    min-height: 420px;
}

.map-embed__frame :deep(iframe) {
    display: block;
    width: 100% !important;
    min-height: 420px;
    border: 0;
}

.swal-title {
    font-size: 1rem;
    font-weight: bold;
}

.card input:focus,
.card textarea:focus {
    border-color: #15803d;
    box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.2);
}

@media (max-width: 767px) {
    .head-office-card {
        padding: 1.5rem;
    }

    .map-embed__frame,
    .map-embed__frame :deep(iframe) {
        min-height: 300px;
    }
}
</style>
