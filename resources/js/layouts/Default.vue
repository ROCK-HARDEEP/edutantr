<template>
    <div class="min-h-screen flex flex-col bg-white">
        <!-- Header -->
        <header
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white border-b border-slate-100"
            :class="isScrolled ? 'shadow-lg' : ''"
        >
            <Header
                :is-scrolled="isScrolled"
                :is-home-overlay="false"
            />
        </header>

        <!-- Main Content -->
        <main
            class="flex-grow"
            :class="isHomePage ? 'pt-0' : 'pt-[72px]'"
        >
            <!-- WhatsApp Support -->
            <div
                v-if="masterStore?.masterData?.whatsapp_support_number"
                class="fixed bottom-6 right-6 z-[99] flex flex-col items-end gap-3"
            >
                <a
                    v-if="masterStore?.masterData?.whatsapp_support_title"
                    :href="masterStore?.masterData?.whatsapp_support_number"
                    target="_blank"
                    class="bg-white text-slate-700 px-4 py-2 rounded-xl shadow-lg text-sm font-medium whitespace-nowrap hover:bg-primary-50 transition-colors"
                >
                    {{ masterStore?.masterData?.whatsapp_support_title }} 💬
                </a>
                <a
                    :href="masterStore?.masterData?.whatsapp_support_number + '?text=Hi%2C%20I%27m%20interested%20in%20your%20courses.%20Can%20you%20help%20me%20get%20started%3F'"
                    target="_blank"
                    class="w-14 h-14 rounded-full bg-white border-2 border-green-500 shadow-lg flex items-center justify-center hover:scale-110 transition-transform"
                >
                    <img
                        src="/public/whatsapp/support.svg"
                        alt="WhatsApp"
                        class="w-6 h-6"
                    />
                </a>
            </div>

            <!-- Floating Enroll CTA -->
            <transition name="slide-right">
                <div
                    v-if="showFloatingCTA && !floatingCTADismissed"
                    class="fixed bottom-[88px] right-6 z-[90] flex items-center"
                >
                    <a
                        href="/programs"
                        class="flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 text-white pl-5 pr-6 py-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 font-semibold text-sm md:text-base"
                    >
                        <span class="hidden sm:inline">Enroll Now</span>
                        <span class="sm:hidden text-lg">🎓</span>
                        <i class="bi bi-arrow-right text-base"></i>
                    </a>
                    <button
                        @click="floatingCTADismissed = true"
                        class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-700 text-white text-xs flex items-center justify-center hover:bg-slate-900 transition-colors shadow"
                    >
                        <i class="bi bi-x text-xs"></i>
                    </button>
                </div>
            </transition>

            <slot />
        </main>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup>
import { useMasterStore } from "@/stores/master";
import { useRoute } from "vue-router";
import { ref, computed, onMounted, onUnmounted } from "vue";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";

const masterStore = useMasterStore();
const route = useRoute();
const isScrolled = ref(false);
const showFloatingCTA = ref(false);
const floatingCTADismissed = ref(false);

const isHomePage = computed(() => route.path === "/");

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

const handleFloatingCTA = () => {
    showFloatingCTA.value = window.scrollY > 600;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll, { passive: true });
    handleScroll();
    window.addEventListener("scroll", handleFloatingCTA, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
    window.removeEventListener("scroll", handleFloatingCTA);
});

</script>

<style scoped>
.slide-right-enter-active,
.slide-right-leave-active {
    transition: transform 0.4s ease, opacity 0.4s ease;
}
.slide-right-enter-from,
.slide-right-leave-to {
    transform: translateX(120%);
    opacity: 0;
}
</style>
