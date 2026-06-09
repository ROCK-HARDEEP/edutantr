<template>
    <nav
        class="navbar navbar-expand-lg sticky-top navbar-modern"
        :class="{ 'navbar-modern--scrolled': isScrolled }"
    >
        <div class="container navbar-modern__inner">
            <router-link to="/" class="navbar-brand brand-logo" aria-label="Edutantr Home">
                <span class="brand-logo__icon" aria-hidden="true">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
                <span class="brand-logo__wordmark">
                    <span class="brand-logo__edu">Edu</span><span class="brand-logo__tantr">tantr</span>
                </span>
            </router-link>

            <button
                class="navbar-toggler navbar-toggler-modern"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon-modern">
                    <i class="bi bi-list"></i>
                </span>
            </button>

            <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarContent">
                <ul class="navbar-nav navbar-nav-modern mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link to="/" :class="['nav-link nav-pill', $route.path === '/' ? 'active' : '']">
                            <i class="bi bi-house-door"></i>
                            {{ $t('Home') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            to="/courses"
                            :class="['nav-link nav-pill', $route.path === '/courses' ? 'active' : '']"
                        >
                            <i class="bi bi-journal-bookmark"></i>
                            {{ $t('Courses') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            to="/college-mou-gallery"
                            :class="['nav-link nav-pill', $route.path.startsWith('/college-mou-gallery') ? 'active' : '']"
                        >
                            <i class="bi bi-images"></i>
                            {{ $t('MOU & Gallery') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            to="/careers"
                            :class="['nav-link nav-pill', $route.path.startsWith('/careers') ? 'active' : '']"
                        >
                            <i class="bi bi-briefcase"></i>
                            {{ $t('Careers') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            to="/about-us"
                            :class="['nav-link nav-pill', $route.path === '/about-us' ? 'active' : '']"
                        >
                            <i class="bi bi-info-circle"></i>
                            {{ $t('About Us') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            to="/contact-us"
                            :class="['nav-link nav-pill', $route.path === '/contact-us' ? 'active' : '']"
                        >
                            <i class="bi bi-envelope"></i>
                            {{ $t('Contact Us') }}
                        </router-link>
                    </li>
                    <li
                        v-if="authStore.authToken"
                        class="nav-item nav-item-profile d-flex align-items-center justify-content-center ms-lg-2"
                    >
                        <div class="dropdown">
                            <button
                                class="profile-btn"
                                type="button"
                                id="profileDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <img :src="authStore.userData.profile_picture" alt="Profile" class="profile-btn__img" />
                                <span class="profile-btn__ring"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown shadow-lg" aria-labelledby="profileDropdown">
                                <router-link to="/dashboard" class="dropdown-item">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    {{ $t('Dashboard') }}
                                </router-link>
                                <router-link to="/dashboard/profile" class="dropdown-item">
                                    <i class="bi bi-person me-2"></i>
                                    {{ $t('Profile') }}
                                </router-link>
                                <router-link to="/dashboard/courses" class="dropdown-item">
                                    <i class="bi bi-book me-2"></i>
                                    {{ $t('Courses') }}
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger" @click="logout()">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    {{ $t('Logout') }}
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-accent" aria-hidden="true"></div>
    </nav>
</template>

<style scoped lang="scss">
.navbar-modern {
    position: relative;
    padding: 0;
    width: 100%;
    z-index: 1040;
    background: #ffffff;
    border-bottom: 1px solid rgba(48, 108, 60, 0.12);
    box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08);
    transition: background 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
}

.navbar-modern--scrolled {
    background: #ffffff;
    box-shadow: 0 8px 32px rgba(48, 108, 60, 0.12);
    border-bottom-color: rgba(48, 108, 60, 0.12);
}

.navbar-modern__inner {
    position: relative;
    padding-top: 0.65rem;
    padding-bottom: 0.65rem;
}

.navbar-accent {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #14532d, #22c55e, #4ade80, #22c55e, #14532d);
    background-size: 200% 100%;
    animation: navbar-shimmer 5s linear infinite;
    opacity: 0.85;
}

@keyframes navbar-shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

.brand-logo {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0;
    text-decoration: none;
    transition: transform 0.25s ease;

    &:hover {
        transform: translateY(-1px);
        text-decoration: none;

        .brand-logo__icon {
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }

        .brand-logo__tantr {
            filter: brightness(1.08);
        }
    }
}

.brand-logo__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #15803d, #22c55e);
    color: #fff;
    font-size: 1.15rem;
    box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);
    transition: box-shadow 0.25s ease;
}

.brand-logo__wordmark {
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -0.03em;
}

.brand-logo__edu {
    color: #14532d;
}

.brand-logo__tantr {
    color: #22c55e;
    background: linear-gradient(135deg, #15803d 0%, #22c55e 50%, #4ade80 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

@media (min-width: 992px) {
    #navbarContent {
        display: flex !important;
        opacity: 1 !important;
        transform: none !important;
        visibility: visible !important;
    }
}

.navbar-nav-modern {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.nav-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 0.95rem !important;
    font-size: 0.84rem;
    font-weight: 600;
    color: #475569 !important;
    border-radius: 50px;
    border: 1px solid transparent;
    transition: all 0.25s ease;
    position: relative;

    i {
        font-size: 0.95rem;
        color: #64748b;
        transition: color 0.25s ease;
    }

    &::after {
        display: none;
    }

    &:hover {
        color: #14532d !important;
        background: rgba(34, 197, 94, 0.08);
        border-color: rgba(34, 197, 94, 0.15);
        transform: translateY(-1px);

        i {
            color: #16a34a;
        }
    }

    &.active {
        color: #fff !important;
        background: linear-gradient(135deg, #15803d, #22c55e);
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(34, 197, 94, 0.35);

        i {
            color: #fff;
        }
    }
}

.navbar-toggler-modern {
    border: 1px solid rgba(48, 108, 60, 0.15);
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    padding: 0.4rem 0.65rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    transition: all 0.25s ease;

    &:focus {
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
    }

    &:hover {
        background: rgba(34, 197, 94, 0.08);
        border-color: rgba(34, 197, 94, 0.3);
    }
}

.navbar-toggler-icon-modern {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #15803d;
    font-size: 1.35rem;
    line-height: 1;
}

.profile-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    padding: 0;
    border: none;
    background: transparent;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.25s ease;

    &:hover {
        transform: scale(1.05);
    }
}

.profile-btn__img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    position: relative;
    z-index: 1;
}

.profile-btn__ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: linear-gradient(135deg, #22c55e, #15803d);
    padding: 2px;
    z-index: 0;
}

.profile-dropdown {
    border: none;
    border-radius: 14px;
    padding: 0.5rem;
    margin-top: 0.5rem !important;
    min-width: 200px;
    border: 1px solid rgba(0, 0, 0, 0.06);

    .dropdown-item {
        border-radius: 10px;
        padding: 0.55rem 0.85rem;
        font-size: 0.88rem;
        font-weight: 500;
        transition: all 0.2s ease;

        &:hover {
            background: rgba(34, 197, 94, 0.1);
            color: #15803d;
        }
    }
}

@media (max-width: 991.98px) {
    .brand-logo__wordmark {
        font-size: 1.45rem;
    }

    .brand-logo__icon {
        width: 36px;
        height: 36px;
        font-size: 1rem;
    }

    .navbar-modern__inner {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    #navbarContent {
        margin-top: 0.75rem;
        padding: 1rem;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(48, 108, 60, 0.1);
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.12);
    }

    #navbarContent.collapsing {
        transition: height 0.3s ease;
    }

    #navbarContent.collapse:not(.show) {
        display: none;
    }

    #navbarContent.collapse.show {
        display: block;
    }

    .navbar-nav-modern {
        gap: 0.35rem;
        width: 100%;
    }

    .nav-item {
        width: 100%;
    }

    .nav-pill {
        width: 100%;
        justify-content: flex-start;
        padding: 0.75rem 1rem !important;
        font-size: 0.92rem;
        border-radius: 12px;

        &.active {
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.25);
        }
    }

    .nav-item-profile {
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid rgba(48, 108, 60, 0.1);
    }
}
</style>

<script setup>
import { useAuthStore } from "@/stores/auth";
import Swal from "sweetalert2";
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useI18n } from "vue-i18n";

const router = useRouter();
const authStore = useAuthStore();
const isLoggedIn = ref(false);
const isScrolled = ref(false);
const { t } = useI18n();

const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    if (authStore.authToken) {
        isLoggedIn.value = true;
    }
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

function logout() {
    Swal.fire({
        title: t("Are you sure?"),
        text: t("Do you want to log out?"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#306c3c",
        cancelButtonColor: "#d33",
        confirmButtonText: t("Yes, log out!"),
        cancelButtonText: t("No"),
    }).then((result) => {
        if (result.isConfirmed) {
            authStore.clearAuthData();

            Swal.fire({
                title: t("Logged Out!"),
                text: t("Log out successful."),
                showConfirmButton: false,
                icon: "success",
                timer: 1500,
            });
        }
        router.push("/");
    });
}
</script>
