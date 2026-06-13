<template>
    <div class="ambassador-page">
        <!-- Hero -->
        <section class="ambassador-hero">
            <img
                class="ambassador-hero__bg"
                :src="heroBg"
                alt=""
                aria-hidden="true"
            />
            <div class="ambassador-hero__overlay" aria-hidden="true"></div>
            <div class="container position-relative ambassador-hero__content">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-9 col-xl-8">
                        <span class="ambassador-hero__badge">
                            <i class="bi bi-stars me-2"></i>
                            {{ $t('Campus Ambassador Program') }}
                        </span>
                        <h1 class="ambassador-hero__title">
                            {{ $t('Become a') }}
                            <span class="ambassador-hero__brand">{{ brandName }}</span>
                            {{ $t('Ambassador Today') }}
                        </h1>
                        <p class="ambassador-hero__subtitle">
                            {{
                                $t(
                                    "Kick-start your career before you finish college. Develop skills, explore opportunities, build your network, and earn while representing our brand on campus."
                                )
                            }}
                        </p>
                        <button type="button" class="btn ambassador-cta-btn btn-lg" @click="scrollToForm">
                            {{ $t('Join as Ambassador') }}
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Roles & Responsibilities -->
        <section class="py-5 ambassador-section">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-label">{{ $t('Roles & Responsibilities') }}</span>
                    <h2 class="fw-bold display-6 mt-2">{{ $t("Here's how the journey unfolds") }}</h2>
                </div>
                <div class="row g-4">
                    <div v-for="role in roles" :key="role.title" class="col-md-6 col-lg-4">
                        <div class="role-card h-100">
                            <div class="role-card__icon">
                                <i :class="role.icon"></i>
                            </div>
                            <h5 class="fw-bold mb-2">{{ role.title }}</h5>
                            <p class="text-muted mb-0">{{ role.description }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <button type="button" class="btn ambassador-cta-btn" @click="scrollToForm">
                        {{ $t('Join as Ambassador') }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Perks & Benefits -->
        <section class="py-5 ambassador-perks">
            <img
                class="ambassador-perks__bg"
                :src="perksBg"
                alt=""
                aria-hidden="true"
            />
            <div class="ambassador-perks__overlay" aria-hidden="true"></div>
            <div class="container position-relative ambassador-perks__content">
                <div class="text-center mb-5">
                    <span class="section-label section-label--light">{{ $t('Perks & Benefits') }}</span>
                    <h2 class="fw-bold display-6 mt-2 text-white">{{ $t('Why you should join') }}</h2>
                </div>
                <div class="row g-4">
                    <div v-for="(perk, index) in perks" :key="perk.title" class="col-md-6 col-lg-4">
                        <div class="perk-card h-100">
                            <span class="perk-card__number">{{ index + 1 }}</span>
                            <div class="perk-card__icon">
                                <i :class="perk.icon"></i>
                            </div>
                            <h5 class="fw-bold mb-2">{{ perk.title }}</h5>
                            <p class="text-muted mb-0">{{ perk.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Application Form -->
        <section id="ambassador-form" class="py-5 bg-light ambassador-form-section">
            <div class="container">
                <div class="row g-4 g-xl-5 align-items-start">
                    <div class="col-lg-5">
                        <span class="section-label">{{ $t('Apply Now') }}</span>
                        <h2 class="fw-bold mb-3">{{ $t('Ready to represent') }} {{ brandName }}?</h2>
                        <p class="text-muted mb-4">
                            {{
                                $t(
                                    'Fill out the form and our team will get in touch with you. Share your college details and tell us why you would be a great campus ambassador.'
                                )
                            }}
                        </p>
                        <ul class="list-unstyled ambassador-checklist">
                            <li v-for="item in checklist" :key="item">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ item }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5">
                            <form @submit.prevent="submitForm">
                                <div class="row g-3">
                                    <div class="col-md-6 form-floating">
                                        <input
                                            id="ambName"
                                            v-model="form.name"
                                            type="text"
                                            class="form-control"
                                            :placeholder="$t('Full Name')"
                                            required
                                        />
                                        <label for="ambName">{{ $t('Full Name') }} *</label>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <input
                                            id="ambEmail"
                                            v-model="form.email"
                                            type="email"
                                            class="form-control"
                                            :placeholder="$t('Email')"
                                            required
                                        />
                                        <label for="ambEmail">{{ $t('Email') }} *</label>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <input
                                            id="ambPhone"
                                            v-model="form.phone"
                                            type="tel"
                                            class="form-control"
                                            :placeholder="$t('Phone Number')"
                                            required
                                        />
                                        <label for="ambPhone">{{ $t('Phone Number') }} *</label>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <input
                                            id="ambCollege"
                                            v-model="form.college"
                                            type="text"
                                            class="form-control"
                                            :placeholder="$t('College / University')"
                                            required
                                        />
                                        <label for="ambCollege">{{ $t('College / University') }} *</label>
                                    </div>
                                    <div class="col-12 form-floating">
                                        <input
                                            id="ambYear"
                                            v-model="form.year"
                                            type="text"
                                            class="form-control"
                                            :placeholder="$t('Year of Study')"
                                            required
                                        />
                                        <label for="ambYear">{{ $t('Year of Study') }} *</label>
                                    </div>
                                    <div class="col-12 form-floating">
                                        <textarea
                                            id="ambMessage"
                                            v-model="form.message"
                                            class="form-control"
                                            :placeholder="$t('Why do you want to become a campus ambassador?')"
                                            rows="4"
                                            style="height: 120px"
                                            required
                                        ></textarea>
                                        <label for="ambMessage">{{ $t('Why do you want to become a campus ambassador?') }} *</label>
                                    </div>
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" class="btn ambassador-cta-btn btn-lg px-5" :disabled="submitting">
                                            <span v-if="submitting" class="spinner-border spinner-border-sm me-2"></span>
                                            {{ $t('Submit Application') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import Swal from "sweetalert2";
import { useMasterStore } from "@/stores/master";
import axios from "axios";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const masterStore = useMasterStore();
const submitting = ref(false);

function publicAsset(relativePath) {
    const pathname = window.location.pathname;
    const publicMarker = "/public/";
    const markerIndex = pathname.indexOf(publicMarker);
    const base =
        markerIndex !== -1
            ? pathname.slice(0, markerIndex + "/public".length)
            : "";
    const normalized = relativePath.replace(/^\//, "");
    return `${base}/${normalized}`;
}

const heroBg = publicAsset("assets/images/profile/ambassador.jpg");
const perksBg = publicAsset("assets/images/profile/ambassador1.jpg");

const brandName = computed(() => masterStore?.masterData?.name || "Edutandr");

const form = ref({
    name: "",
    email: "",
    phone: "",
    college: "",
    year: "",
    message: "",
});

const roles = computed(() => [
    {
        icon: "bi bi-building",
        title: t("Act as a Campus Liaison"),
        description: t("Serve as the direct link between our academy and your college community."),
    },
    {
        icon: "bi bi-megaphone",
        title: t("Promote Our Programs"),
        description: t("Drive awareness through social media and peer engagement on campus."),
    },
    {
        icon: "bi bi-whatsapp",
        title: t("Lead WhatsApp Campaigns"),
        description: t("Build and manage student groups to onboard and inform fellow students."),
    },
    {
        icon: "bi bi-calendar-event",
        title: t("Coordinate Events"),
        description: t("Assist in organizing webinars and outreach activities in coordination with your institution."),
    },
    {
        icon: "bi bi-patch-check",
        title: t("Represent the Brand"),
        description: t("Uphold our identity on campus and promote our initiatives and values."),
    },
]);

const perks = computed(() => [
    {
        icon: "bi bi-gift",
        title: t("Exclusive Learning Rewards"),
        description: t("Earn access to premium courses and learning resources as you hit referral milestones."),
    },
    {
        icon: "bi bi-briefcase",
        title: t("Career Opportunities"),
        description: t("Stand out with exclusive job and internship opportunities through our partner network."),
    },
    {
        icon: "bi bi-mortarboard",
        title: t("Expert-Led Bootcamps"),
        description: t("Join private bootcamps led by industry experts and stay ahead of your peers."),
    },
    {
        icon: "bi bi-cash-stack",
        title: t("Exciting Cash Rewards"),
        description: t("Refer students, lead activities, and participate in campaigns — we reward performance."),
    },
    {
        icon: "bi bi-award",
        title: t("Official Certification"),
        description: t("Boost your resume with a recognised campus ambassador certificate."),
    },
]);

const checklist = computed(() => [
    t("Open to college students across all streams"),
    t("Flexible hours — work alongside your studies"),
    t("Training and marketing support provided"),
    t("Performance-based rewards and recognition"),
]);

function scrollToForm() {
    document.getElementById("ambassador-form")?.scrollIntoView({ behavior: "smooth" });
}

function resetForm() {
    form.value = { name: "", email: "", phone: "", college: "", year: "", message: "" };
}

const submitForm = async () => {
    submitting.value = true;
    try {
        const payload = {
            name: form.value.name,
            email: form.value.email,
            subject: t("Campus Ambassador Application"),
            message: [
                t("Phone") + ": " + form.value.phone,
                t("College / University") + ": " + form.value.college,
                t("Year of Study") + ": " + form.value.year,
                "",
                form.value.message,
            ].join("\n"),
        };

        const response = await axios.post("/contact/submit", payload, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });

        if (response.status === 201) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: t("Your application has been submitted successfully"),
                showConfirmButton: false,
                timer: 2000,
            });
            resetForm();
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: error.response?.data?.message || t("Something went wrong. Please try again."),
            showConfirmButton: false,
            timer: 3500,
        });
    } finally {
        submitting.value = false;
    }
};
</script>

<style scoped lang="scss">
.ambassador-hero {
    position: relative;
    padding: 6rem 0 5rem;
    overflow: hidden;
    min-height: 520px;
    display: flex;
    align-items: center;

    &__bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    &__overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.68);
    }

    &__content {
        z-index: 1;
        width: 100%;
    }

    &__badge {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 1rem;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 1.25rem;
        backdrop-filter: blur(4px);
    }

    &__title {
        font-size: clamp(2rem, 5vw, 3.25rem);
        font-weight: 800;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 1.25rem;
    }

    &__brand {
        color: #fde047;
    }

    &__subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.88);
        line-height: 1.7;
        margin-bottom: 2rem;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
}

.ambassador-cta-btn {
    background: #fde047;
    color: #14532d;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    padding: 0.75rem 2rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;

    &:hover {
        background: #facc15;
        color: #14532d;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    &:disabled {
        opacity: 0.7;
        transform: none;
    }
}

.section-label {
    display: inline-block;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #15803d;

    &--light {
        color: #bbf7d0;
    }
}

.role-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.75rem;
    transition: transform 0.25s ease, box-shadow 0.25s ease;

    &:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(21, 128, 61, 0.12);
    }

    &__icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #ecfdf5, #dcfce7);
        color: #15803d;
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }
}

.ambassador-perks {
    position: relative;
    overflow: hidden;

    &__bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    &__overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.68);
    }

    &__content {
        z-index: 1;
    }
}

.perk-card {
    background: #fff;
    border-radius: 20px;
    padding: 1.75rem;
    position: relative;
    overflow: hidden;
    transition: transform 0.25s ease;

    &:hover {
        transform: translateY(-4px);
    }

    &__number {
        position: absolute;
        top: 1rem;
        right: 1.25rem;
        font-size: 2.5rem;
        font-weight: 800;
        color: #ecfdf5;
        line-height: 1;
    }

    &__icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #15803d;
        color: #fff;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }
}

.ambassador-checklist li {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    margin-bottom: 0.75rem;
    color: #475569;

    i {
        color: #16a34a;
        margin-top: 0.15rem;
        flex-shrink: 0;
    }
}

.ambassador-final-cta {
    background: linear-gradient(135deg, #15803d, #22c55e);
}

.card input:focus,
.card textarea:focus {
    border-color: #15803d;
    box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.2);
}

@media (max-width: 767px) {
    .ambassador-hero {
        padding: 4rem 0 3.5rem;
        min-height: 440px;
    }
}
</style>
