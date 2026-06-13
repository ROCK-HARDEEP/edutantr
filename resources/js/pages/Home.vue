<template>
    <div class="home-page">
        <HomeMarquee />

        <LandingHero />

        <LandingStatistics />

        <section v-reveal="{ delay: 100 }" class="home-section home-section--courses">
            <div class="container">
                <PopularCourses />
            </div>
        </section>

        <section v-reveal:fadeInLeft class="home-section home-section--mentors">
            <MentorsSection />
        </section>

        <div v-reveal:fadeInRight class="home-section home-section--why">
            <WhyChooseUs />
        </div>

        <section v-reveal="{ delay: 150 }" class="home-section home-section--feedback">
            <div class="container">
                <SectionHeader
                    :eyebrow="$t('Student Feedback')"
                    icon="bi bi-chat-quote-fill"
                    :subtitle="$t('Real stories from learners who transformed their careers with us.')"
                >
                    <template #title>
                        {{ $t('Hear from Our') }}
                        <span class="accent">{{ $t('Students & Instructors') }}</span>
                    </template>
                </SectionHeader>
                <Testimonials />
            </div>
        </section>

        <LandingCTA v-reveal:zoomIn />

        <section v-reveal class="home-section home-section--faq">
            <div class="container">
                <FAQ />
            </div>
        </section>

        <OfferModal />
    </div>
</template>

<style scoped>
.home-page {
    overflow-x: hidden;
}

.home-section {
    padding: 4rem 0;
}

.home-section--courses {
    background:
        radial-gradient(ellipse 75% 55% at 8% 45%, rgba(255, 210, 190, 0.55) 0%, transparent 58%),
        radial-gradient(ellipse 70% 50% at 92% 35%, rgba(186, 220, 255, 0.5) 0%, transparent 55%),
        #f8fafc;
    padding: 5rem 0;
}

.home-section--mentors {
    padding: 0;
    background: #fff;
}

.home-section--why {
    padding: 0;
    background: #fff;
}

.home-section--feedback {
    background: linear-gradient(180deg, #ecfdf5 0%, #f8fafc 100%);
    position: relative;
}

.home-section--feedback::before {
    content: "";
    position: absolute;
    inset: 0;
    background: url("/public/assets/website/pricing-bg.png") no-repeat center;
    background-size: cover;
    opacity: 0.2;
    pointer-events: none;
}

.home-section--feedback .container {
    position: relative;
    z-index: 1;
}

.home-section--faq {
    background: #fff;
    padding-bottom: 2rem;
}

@media (max-width: 767px) {
    .home-section {
        padding: 2.5rem 0;
    }
}
</style>

<script setup>
import { useMasterStore } from "@/stores/master";
import { useLocaleStore } from "../stores/locale";
import { onMounted } from "vue";
import HomeMarquee from "../components/landing/HomeMarquee.vue";
import LandingHero from "../components/landing/LandingHero.vue";
import LandingStatistics from "../components/landing/LandingStatistics.vue";
import SectionHeader from "../components/landing/SectionHeader.vue";
import WhyChooseUs from "../components/landing/WhyChooseUs.vue";
import LandingCTA from "../components/landing/LandingCTA.vue";
import FAQ from "../components/FAQ.vue";
import Testimonials from "../components/Testimonials.vue";
import PopularCourses from "../components/PopularCourses.vue";
import MentorsSection from "../components/landing/MentorsSection.vue";
import OfferModal from "../components/OfferModal.vue";

const masterStore = useMasterStore();
const localeStore = useLocaleStore();

onMounted(async () => {
    await axios
        .get(`/master`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        })
        .then((response) => {
            masterStore.setMasterData(response.data.data.master);

            if (localeStore.defaultLanguage !== masterStore.masterData.default_language) {
                localeStore.setLang(masterStore.masterData.default_language);
                localeStore.setDefaultLang(masterStore.masterData.default_language);
                location.reload();
            }
        })
        .catch((error) => {
            console.error("Error fetching data:", error.response?.data?.message ?? error);
        });
});
</script>
