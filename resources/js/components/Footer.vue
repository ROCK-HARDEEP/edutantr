<template>
    <footer
        class="text-white mt-20 bg-cover bg-no-repeat bg-center"
        :style="{
            backgroundImage: masterStore?.masterData?.footer_bg_thumbnail
                ? `url(${masterStore.masterData.footer_bg_thumbnail})`
                : 'url(/assets/website/footer-bg-2.png)',
        }"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8 border-b border-white/15 pb-12">
                <!-- Brand & Contact -->
                <div class="lg:col-span-1">
                    <BrandLogo to="/" variant="light" class="mb-4" />
                    <p class="text-white/75 text-sm leading-relaxed max-w-xs mb-6">
                        {{ masterStore?.masterData?.footer_description }}
                    </p>
                    <ul class="space-y-3">
                        <li>
                            <a
                                :href="`tel:${masterStore?.masterData?.footer_contact}`"
                                class="flex items-center gap-3 text-white/80 hover:text-primary-300 transition-colors text-sm"
                            >
                                <i class="bi bi-telephone"></i>
                                {{ masterStore?.masterData?.footer_contact }}
                            </a>
                        </li>
                        <li>
                            <a
                                :href="masterStore?.masterData?.footer_email
                                    ? `mailto:${masterStore?.masterData?.footer_email}`
                                    : ''"
                                class="flex items-center gap-3 text-white/80 hover:text-primary-300 transition-colors text-sm"
                            >
                                <i class="bi bi-envelope"></i>
                                {{ masterStore?.masterData?.footer_email }}
                            </a>
                        </li>
                    </ul>

                    <!-- Social Icons -->
                    <div class="flex items-center gap-3 mt-6">
                        <a
                            v-for="social in masterStore?.masterData?.footer_social_icons"
                            :key="social.name"
                            :href="social?.url"
                            target="_blank"
                            class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-primary-500 hover:text-white transition-all duration-200"
                        >
                            <i :class="social?.icon" class="text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-5 uppercase tracking-wider">
                        {{ $t('Quick Links') }}
                    </h4>
                    <ul class="space-y-3">
                        <li v-for="link in quickLinks" :key="link.path">
                            <router-link
                                :to="link.path"
                                class="text-white/70 hover:text-primary-300 transition-colors text-sm flex items-center gap-2"
                            >
                                <i class="bi bi-chevron-right text-xs opacity-50"></i>
                                {{ $t(link.label) }}
                            </router-link>
                        </li>
                    </ul>
                </div>

                <!-- Help & Support -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-5 uppercase tracking-wider">
                        {{ $t('Help & Support') }}
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <router-link
                                to="/contact-us"
                                class="text-white/70 hover:text-primary-300 transition-colors text-sm flex items-center gap-2"
                            >
                                <i class="bi bi-chevron-right text-xs opacity-50"></i>
                                {{ $t('Contact Us') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/page/terms_and_conditions"
                                class="text-white/70 hover:text-primary-300 transition-colors text-sm flex items-center gap-2"
                            >
                                <i class="bi bi-chevron-right text-xs opacity-50"></i>
                                {{ $t('Terms & Conditions') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/page/privacy_policy"
                                class="text-white/70 hover:text-primary-300 transition-colors text-sm flex items-center gap-2"
                            >
                                <i class="bi bi-chevron-right text-xs opacity-50"></i>
                                {{ $t('Privacy Policy') }}
                            </router-link>
                        </li>
                    </ul>

                    <!-- Newsletter -->
                    <div class="mt-6">
                        <h6 class="text-white font-semibold text-sm mb-3">
                            {{ $t('Subscribe to Newsletter') }}
                        </h6>
                        <form @submit.prevent="newsletter()" class="flex">
                            <input
                                type="email"
                                v-model="suscribeEmail"
                                :placeholder="$t('Enter your email')"
                                required
                                class="flex-1 px-4 py-2.5 rounded-l-lg bg-white/10 border border-white/20 text-white text-sm placeholder-white/40 focus:outline-none focus:border-primary-400"
                            />
                            <button
                                type="submit"
                                class="px-4 py-2.5 rounded-r-lg bg-primary-600 text-white hover:bg-primary-500 transition-colors"
                            >
                                <i class="bi bi-send-fill text-sm"></i>
                            </button>
                        </form>
                        <p class="text-white/40 text-xs mt-2">
                            {{ $t('No spam. Unsubscribe anytime.') }}
                        </p>
                    </div>
                </div>

                <!-- Download App -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-5 uppercase tracking-wider">
                        {{ $t('Download Our App') }}
                    </h4>
                    <div class="bg-white rounded-xl p-3 inline-block mb-4">
                        <img
                            :src="masterStore?.masterData?.scaner ||
                                'https://quickchart.io/qr?text=' + baseUrl + '/download_app&margin=2&size=110'"
                            class="block w-[140px] h-[110px] object-contain"
                            alt="Scan QR code"
                        />
                        <small class="text-slate-700 text-xs text-center block mt-1">
                            {{ $t('Scan the QR code') }}
                        </small>
                    </div>
                    <div class="flex gap-3">
                        <a :href="masterStore?.masterData?.footer_apple_link" target="_blank">
                            <img
                                src="/public/assets/images/website/app-store.png"
                                alt="App Store"
                                class="h-10 hover:opacity-80 transition-opacity"
                            />
                        </a>
                        <a :href="masterStore?.masterData?.footer_google_link" target="_blank">
                            <img
                                src="/public/assets/images/website/play-store.png"
                                alt="Play Store"
                                class="h-10 hover:opacity-80 transition-opacity"
                            />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center py-6">
                <small class="text-white/60 text-sm">{{ masterStore?.masterData?.credit_text }}</small>
            </div>
        </div>
    </footer>
</template>

<script setup>
import BrandLogo from "@/components/BrandLogo.vue";
import { useMasterStore } from "@/stores/master";
import { ref } from "vue";
import { useI18n } from "vue-i18n";
import Swal from "sweetalert2";

const masterStore = useMasterStore();
const { t } = useI18n();
const suscribeEmail = ref("");
const baseUrl = import.meta.env.VITE_APP_URL;

const quickLinks = [
    { path: "/college-mou-gallery", label: "MOU & Gallery" },
    { path: "/page/about_us", label: "About Us" },
    { path: "/campus-ambassador", label: "Campus Ambassador" },
    { path: "/faq", label: "FAQ" },
    { path: "/admin/register", label: "Become a Teacher" },
];

const newsletter = () => {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(suscribeEmail.value)) {
        Swal.fire({
            icon: "error",
            title: "Invalid email address",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });
        return;
    }

    axios.post("/newslatter/subscribe", { email: suscribeEmail.value })
        .then(() => {
            Swal.fire({
                icon: "success",
                title: t("Thank you for subscribing to our newsletter"),
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
            suscribeEmail.value = "";
        })
        .catch((error) => {
            console.error(error);
        });
};
</script>
