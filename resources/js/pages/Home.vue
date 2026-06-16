<template>
    <div class="home-page" style="overflow-x: clip;">
        <!-- Hero -->
        <LandingHero />


        <!-- How It Works -->
        <section v-reveal.reveal-up class="py-16 md:py-20">
            <OurProcess />
        </section>

        <!-- Placements + Statistics -->
        <LandingStatistics v-reveal.reveal-up />

        <!-- Popular Courses -->
        <section v-reveal.reveal-up class="py-16 md:py-20 bg-gradient-to-br from-orange-50/50 via-blue-50/30 to-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <PopularCourses />
            </div>
        </section>

        <!-- Career Tracks -->
        <div v-reveal.reveal-scale id="career-tracks">
            <CareerTracks />
        </div>

        <!-- Mentors -->
        <section v-reveal.reveal-left class="py-0 bg-white">
            <MentorsSection />
        </section>

        <!-- Industry Partners -->
        <section v-reveal.reveal-right class="py-0 bg-white">
            <IndustryPartnersSlider />
        </section>

        <!-- Why Choose Us (hidden, set showWhyChooseUs=true to enable) -->
        <section v-if="showWhyChooseUs" class="py-0 bg-white">
            <WhyChooseUs />
        </section>

        <!-- Student Feedback -->
        <section v-reveal.reveal-up class="py-16 md:py-20 bg-gradient-to-b from-primary-50/30 to-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <SectionHeader
                    :eyebrow="$t('Student Feedback')"
                    icon="bi bi-chat-quote-fill"
                    :subtitle="$t('Real stories from learners who transformed their careers with us.')"
                >
                    <template #title>
                        {{ $t('Hear from Our') }}
                        <span class="gradient-text">{{ $t('Students & Instructors') }}</span>
                    </template>
                </SectionHeader>
                <Testimonials />
            </div>
        </section>

        <!-- CTA -->
        <LandingCTA v-reveal.reveal-scale />

        <!-- FAQ -->
        <section v-reveal.reveal-up class="py-16 md:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <FAQ />
            </div>
        </section>

        <!-- Offer Modal -->
        <OfferModal />


    </div>
</template>

<script setup>
import { useMasterStore } from "@/stores/master";
import { useLocaleStore } from "../stores/locale";
import { onMounted } from "vue";
import LandingHero from "../components/landing/LandingHero.vue";
import LandingStatistics from "../components/landing/LandingStatistics.vue";
import SectionHeader from "../components/landing/SectionHeader.vue";
import WhyChooseUs from "../components/landing/WhyChooseUs.vue";
import LandingCTA from "../components/landing/LandingCTA.vue";
import FAQ from "../components/FAQ.vue";
import Testimonials from "../components/Testimonials.vue";
import PopularCourses from "../components/PopularCourses.vue";
import MentorsSection from "../components/landing/MentorsSection.vue";
import OurProcess from "../components/landing/OurProcess.vue";
import IndustryPartnersSlider from "../components/landing/IndustryPartnersSlider.vue";
import CareerTracks from "../components/landing/CareerTracks.vue";
import OfferModal from "../components/OfferModal.vue";


const masterStore = useMasterStore();
const localeStore = useLocaleStore();
const showWhyChooseUs = false;

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
