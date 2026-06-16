<template>
    <nav class="w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">
                <!-- Brand Logo -->
                <router-link to="/" class="flex-shrink-0">
                    <img
                        v-if="masterStore?.masterData?.logo"
                        :src="isHomeOverlay ? masterStore.masterData.white_logo || masterStore.masterData.logo : masterStore.masterData.logo"
                        :alt="masterStore?.masterData?.name"
                        class="h-10 w-auto"
                    />
                    <span
                        v-else
                        class="text-xl font-bold"
                        :class="isHomeOverlay ? 'text-white' : 'text-primary-700'"
                    >
                        Edutantr
                    </span>
                </router-link>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-1">
                    <router-link
                        v-for="item in navItems"
                        :key="item.path"
                        :to="item.path"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2"
                        :class="getNavClass(item.path)"
                    >
                        <i :class="item.icon" class="text-sm"></i>
                        {{ $t(item.label) }}
                    </router-link>
                </div>

                <!-- Desktop Actions -->
                <div class="hidden lg:flex items-center gap-3">
                    <!-- Dark Mode Toggle -->
                    <button
                        @click="toggleDarkMode"
                        class="p-2 rounded-full transition-all duration-200"
                        :class="isHomeOverlay
                            ? 'text-white/80 hover:text-white hover:bg-white/10'
                            : 'text-slate-500 hover:text-primary-700 hover:bg-primary-50'"
                        :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                    >
                        <i :class="isDark ? 'bi bi-sun-fill text-lg' : 'bi bi-moon-fill text-lg'"></i>
                    </button>

                    <template v-if="!authStore.authToken">
                        <router-link
                            to="/login"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200"
                            :class="isHomeOverlay
                                ? 'text-white/90 hover:text-white hover:bg-white/10'
                                : 'text-slate-600 hover:text-primary-700 hover:bg-primary-50'"
                        >
                            {{ $t('Student Login') }}
                        </router-link>
                        <router-link
                            to="/register"
                            class="px-5 py-2.5 rounded-full text-sm font-bold text-white transition-all duration-200 bg-gradient-to-r from-primary-700 to-primary-500 shadow-lg shadow-primary-500/25 hover:shadow-primary-500/40 hover:-translate-y-0.5"
                        >
                            {{ $t('Get Started') }}
                        </router-link>
                    </template>

                    <!-- Profile Dropdown -->
                    <div v-else class="relative">
                        <button
                            @click="showProfile = !showProfile"
                            class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-100 transition-colors"
                        >
                            <img
                                :src="authStore.userData?.profile_picture"
                                alt="Profile"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md"
                            />
                        </button>
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 scale-95 translate-y-1"
                            enter-to-class="opacity-100 scale-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 scale-100 translate-y-0"
                            leave-to-class="opacity-0 scale-95 translate-y-1"
                        >
                            <div
                                v-if="showProfile"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50"
                            >
                                <router-link
                                    to="/dashboard"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors"
                                    @click="showProfile = false"
                                >
                                    <i class="bi bi-speedometer2"></i>
                                    {{ $t('Dashboard') }}
                                </router-link>
                                <router-link
                                    to="/dashboard/profile"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors"
                                    @click="showProfile = false"
                                >
                                    <i class="bi bi-person"></i>
                                    {{ $t('Profile') }}
                                </router-link>
                                <router-link
                                    to="/dashboard/courses"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors"
                                    @click="showProfile = false"
                                >
                                    <i class="bi bi-book"></i>
                                    {{ $t('Courses') }}
                                </router-link>
                                <div class="border-t border-slate-100 my-1"></div>
                                <button
                                    @click="logout()"
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors w-full"
                                >
                                    <i class="bi bi-box-arrow-right"></i>
                                    {{ $t('Logout') }}
                                </button>
                            </div>
                        </Transition>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 rounded-xl transition-colors"
                    :class="isHomeOverlay
                        ? 'text-white hover:bg-white/10'
                        : 'text-slate-600 hover:bg-slate-100'"
                >
                    <i :class="mobileMenuOpen ? 'bi bi-x-lg text-xl' : 'bi bi-list text-2xl'"></i>
                </button>

                <!-- Mobile Dark Mode Toggle -->
                <button
                    @click="toggleDarkMode"
                    class="lg:hidden p-2 rounded-xl transition-colors"
                    :class="isHomeOverlay
                        ? 'text-white/80 hover:bg-white/10'
                        : 'text-slate-500 hover:bg-slate-100'"
                    :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                >
                    <i :class="isDark ? 'bi bi-sun-fill text-lg' : 'bi bi-moon-fill text-lg'"></i>
                </button>
            </div>
        </div>

        <!-- Accent Bar -->
        <div
            class="h-[3px] bg-gradient-to-r from-primary-900 via-primary-400 to-primary-900 bg-[length:200%_100%] animate-[shimmer_5s_linear_infinite]"
            :class="isHomeOverlay ? 'opacity-0' : 'opacity-80'"
        ></div>

        <!-- Mobile Menu -->
        <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div
                v-if="mobileMenuOpen"
                class="lg:hidden absolute top-[75px] left-0 right-0 bg-white/95 backdrop-blur-xl border-b border-slate-100 shadow-xl z-40"
            >
                <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                    <router-link
                        v-for="item in navItems"
                        :key="item.path"
                        :to="item.path"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200"
                        :class="$route.path === item.path || $route.path.startsWith(item.path + '/')
                            ? 'bg-primary-50 text-primary-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        @click="mobileMenuOpen = false"
                    >
                        <i :class="item.icon" class="text-lg w-5 text-center"></i>
                        {{ $t(item.label) }}
                    </router-link>

                    <div class="border-t border-slate-100 my-3"></div>

                    <template v-if="!authStore.authToken">
                        <router-link
                            to="/login"
                            class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="bi bi-box-arrow-in-right"></i>
                            {{ $t('Student Login') }}
                        </router-link>
                        <router-link
                            to="/register"
                            class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-primary-700 to-primary-500 shadow-lg"
                            @click="mobileMenuOpen = false"
                        >
                            {{ $t('Get Started') }}
                        </router-link>
                    </template>

                    <template v-else>
                        <router-link
                            to="/dashboard"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors"
                            @click="mobileMenuOpen = false"
                        >
                            <i class="bi bi-speedometer2 text-lg w-5 text-center"></i>
                            {{ $t('Dashboard') }}
                        </router-link>
                        <button
                            @click="logout(); mobileMenuOpen = false"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors w-full"
                        >
                            <i class="bi bi-box-arrow-right text-lg w-5 text-center"></i>
                            {{ $t('Logout') }}
                        </button>
                    </template>
                </div>
            </div>
        </Transition>
    </nav>
</template>

<script setup>
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useI18n } from "vue-i18n";
import Swal from "sweetalert2";

const props = defineProps({
    isScrolled: { type: Boolean, default: false },
    isHomeOverlay: { type: Boolean, default: false },
});

const router = useRouter();
const authStore = useAuthStore();
const masterStore = useMasterStore();
const { t } = useI18n();

const mobileMenuOpen = ref(false);
const showProfile = ref(false);

// Dark mode
const isDark = ref(false);

const toggleDarkMode = () => {
    isDark.value = !isDark.value;
    applyDarkMode();
    localStorage.setItem("edutantr-dark-mode", isDark.value);
};

const applyDarkMode = () => {
    if (isDark.value) {
        document.documentElement.classList.add("dark-mode");
    } else {
        document.documentElement.classList.remove("dark-mode");
    }
};

const navItems = [
    { path: "/", label: "Home", icon: "bi bi-house-door" },
    { path: "/programs", label: "Courses", icon: "bi bi-journal-bookmark" },
    { path: "/careers", label: "Careers", icon: "bi bi-briefcase" },
    { path: "/about-us", label: "About Us", icon: "bi bi-info-circle" },
    { path: "/contact-us", label: "Contact Us", icon: "bi bi-envelope" },
];

const getNavClass = (path) => {
    const isActive =
        path === "/"
            ? router.currentRoute.value.path === "/"
            : router.currentRoute.value.path.startsWith(path);

    if (props.isHomeOverlay) {
        return isActive
            ? "bg-white/18 text-white border border-white/25 shadow-sm"
            : "text-white/85 hover:text-white hover:bg-white/12 border border-transparent";
    }

    return isActive
        ? "bg-gradient-to-r from-primary-700 to-primary-500 text-white shadow-lg shadow-primary-500/30"
        : "text-slate-600 hover:text-primary-700 hover:bg-primary-50/80 border border-transparent";
};

const logout = () => {
    Swal.fire({
        title: t("Are you sure?"),
        text: t("You will be logged out of your account"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#15803d",
        cancelButtonColor: "#64748b",
        confirmButtonText: t("Yes, logout"),
    }).then((result) => {
        if (result.isConfirmed) {
            authStore.logout();
            router.push("/");
        }
    });
};

// Close dropdown on outside click
const handleClickOutside = (e) => {
    if (showProfile.value && !e.target.closest(".relative")) {
        showProfile.value = false;
    }
};

onMounted(() => {
    // Initialize dark mode from localStorage
    const savedDark = localStorage.getItem("edutantr-dark-mode");
    if (savedDark === "true") {
        isDark.value = true;
        applyDarkMode();
    } else if (savedDark === null) {
        // Check system preference
        const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        if (prefersDark) {
            isDark.value = true;
            applyDarkMode();
        }
    }

    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>
