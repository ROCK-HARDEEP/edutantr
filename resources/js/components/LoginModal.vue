<template>
    <Teleport to="body">
        <div v-if="modelValue" class="login-modal-backdrop" @click.self="close">
            <div class="login-modal" role="dialog" aria-modal="true" :aria-label="activeTab === 'login' ? $t('Login') : $t('Sign up')">
                <button type="button" class="login-modal__close" :aria-label="$t('Close')" @click="close">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="login-modal__header text-center">
                    <BrandLogo to="/" centered size="md" />
                    <h3 class="fw-bold mt-3 mb-1">
                        {{ activeTab === 'login' ? $t('Login') : $t('Sign up') }}
                    </h3>
                    <p class="text-muted mb-0">{{ $t('Sign in to continue with checkout') }}</p>
                </div>

                <div class="login-modal__tabs">
                    <button
                        type="button"
                        :class="['login-modal__tab', activeTab === 'login' ? 'login-modal__tab--active' : '']"
                        @click="switchTab('login')"
                    >
                        {{ $t('Login') }}
                    </button>
                    <button
                        type="button"
                        :class="['login-modal__tab', activeTab === 'register' ? 'login-modal__tab--active' : '']"
                        @click="switchTab('register')"
                    >
                        {{ $t('Sign up') }}
                    </button>
                </div>

                <form v-if="activeTab === 'login'" class="login-modal__form" @submit.prevent="loginUser">
                    <div class="mb-3">
                        <input
                            v-model="email"
                            type="email"
                            class="form-control"
                            :placeholder="$t('Email Address')"
                            autocomplete="email"
                        />
                        <p v-if="errors.email" class="text-danger fw-bold mt-2 mb-0 small">
                            {{ errors.email[0] }}
                        </p>
                    </div>

                    <div class="mb-3 position-relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            v-model="password"
                            class="form-control"
                            :placeholder="$t('Password')"
                            autocomplete="current-password"
                        />
                        <p v-if="errors.password" class="text-danger fw-bold mt-2 mb-0 small">
                            {{ errors.password[0] }}
                        </p>
                        <button
                            type="button"
                            class="login-modal__eye"
                            @click="showPassword = !showPassword"
                            tabindex="-1"
                        >
                            <i :class="showPassword ? 'bi bi-eye' : 'bi bi-eye-slash'"></i>
                        </button>
                    </div>

                    <router-link to="/reset_password" class="small d-block text-decoration-none mb-3" @click="close">
                        {{ $t('Forgot your password') }}?
                    </router-link>

                    <button type="submit" class="btn btn-primary w-100 rounded-2" :disabled="loader">
                        <span :class="{ loader: loader }">{{ loginBtnText }}</span>
                    </button>
                </form>

                <form v-else class="login-modal__form" @submit.prevent="registerUser">
                    <div class="mb-3">
                        <input
                            v-model="name"
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': errors.name }"
                            :placeholder="$t('Full Name')"
                            autocomplete="name"
                        />
                        <p v-if="errors.name" class="text-danger fw-bold mt-2 mb-0 small">{{ errors.name[0] }}</p>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-sm-6">
                            <input
                                v-model="phone"
                                type="tel"
                                class="form-control"
                                :class="{ 'is-invalid': errors.phone }"
                                :placeholder="$t('Phone Number')"
                                autocomplete="tel"
                            />
                            <p v-if="errors.phone" class="text-danger fw-bold mt-2 mb-0 small">{{ errors.phone[0] }}</p>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input
                                v-model="registerEmail"
                                type="email"
                                class="form-control"
                                :class="{ 'is-invalid': errors.email }"
                                :placeholder="$t('Email')"
                                autocomplete="email"
                            />
                            <p v-if="errors.email" class="text-danger fw-bold mt-2 mb-0 small">{{ errors.email[0] }}</p>
                        </div>
                    </div>

                    <div class="mb-3 mt-2">
                        <input
                            v-model="collegeName"
                            type="text"
                            class="form-control"
                            :class="{ 'is-invalid': errors.college_name }"
                            :placeholder="$t('College / Institution Name')"
                            autocomplete="organization"
                        />
                        <p v-if="errors.college_name" class="text-danger fw-bold mt-2 mb-0 small">
                            {{ errors.college_name[0] }}
                        </p>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-sm-6 position-relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                v-model="registerPassword"
                                class="form-control"
                                :class="{ 'is-invalid': errors.password }"
                                :placeholder="$t('Create Password')"
                                autocomplete="new-password"
                            />
                            <button
                                type="button"
                                class="login-modal__eye"
                                @click="showPassword = !showPassword"
                                tabindex="-1"
                            >
                                <i :class="showPassword ? 'bi bi-eye' : 'bi bi-eye-slash'"></i>
                            </button>
                            <p v-if="errors.password" class="text-danger fw-bold mt-2 mb-0 small">
                                {{ errors.password[0] }}
                            </p>
                        </div>
                        <div class="col-12 col-sm-6 position-relative">
                            <input
                                :type="showConfirmPassword ? 'text' : 'password'"
                                v-model="passwordConfirm"
                                class="form-control"
                                :placeholder="$t('Confirm Password')"
                                autocomplete="new-password"
                            />
                            <button
                                type="button"
                                class="login-modal__eye"
                                @click="showConfirmPassword = !showConfirmPassword"
                                tabindex="-1"
                            >
                                <i :class="showConfirmPassword ? 'bi bi-eye' : 'bi bi-eye-slash'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 mt-2">
                        <input
                            v-model="teamCode"
                            type="text"
                            maxlength="4"
                            class="form-control"
                            :class="{ 'is-invalid': errors.team_code }"
                            :placeholder="$t('Team Code (4 characters, optional)')"
                        />
                        <p v-if="errors.team_code" class="text-danger fw-bold mt-2 mb-0 small">
                            {{ errors.team_code[0] }}
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-2" :disabled="loader">
                        <span :class="{ loader: loader }">{{ registerBtnText }}</span>
                    </button>
                </form>

                <p class="text-center mb-0 mt-3 small">
                    <template v-if="activeTab === 'login'">
                        {{ $t("Don't have an account") }}?
                        <button type="button" class="btn btn-link btn-sm p-0 align-baseline" @click="switchTab('register')">
                            {{ $t('Sign Up') }}
                        </button>
                    </template>
                    <template v-else>
                        {{ $t('Already have an account') }}?
                        <button type="button" class="btn btn-link btn-sm p-0 align-baseline" @click="switchTab('login')">
                            {{ $t('Log in') }}
                        </button>
                    </template>
                </p>
            </div>
        </div>
    </Teleport>
</template>

<style scoped lang="scss">
.login-modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(4px);
}

.login-modal {
    position: relative;
    width: 100%;
    max-width: 460px;
    max-height: calc(100vh - 2rem);
    overflow-y: auto;
    padding: 2rem 1.75rem 1.5rem;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 24px 60px rgba(15, 23, 42, 0.2);
}

.login-modal__close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    cursor: pointer;
    transition: background 0.2s ease;

    &:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
}

.login-modal__tabs {
    display: flex;
    gap: 0.5rem;
    margin: 1.25rem 0 1rem;
    padding: 0.35rem;
    border-radius: 12px;
    background: #f1f5f9;
}

.login-modal__tab {
    flex: 1;
    border: none;
    background: transparent;
    color: #64748b;
    font-size: 0.88rem;
    font-weight: 600;
    padding: 0.55rem 0.75rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;

    &--active {
        background: #fff;
        color: #15803d;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    }
}

.login-modal__eye {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    color: #64748b;
    cursor: pointer;
    padding: 0;
}

.loader {
    position: relative;
    padding-right: 28px;

    &::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 0;
        width: 18px;
        height: 18px;
        margin-top: -9px;
        border: 2px solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: login-spin 0.75s linear infinite;
    }
}

@keyframes login-spin {
    to {
        transform: rotate(360deg);
    }
}
</style>

<script setup>
import BrandLogo from "@/components/BrandLogo.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { ref, watch } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useI18n } from "vue-i18n";

const props = defineProps({
    modelValue: { type: Boolean, default: false },
});

const emit = defineEmits(["update:modelValue", "success"]);

const authStore = useAuthStore();
const { t } = useI18n();

const activeTab = ref("login");
const email = ref("");
const password = ref("");
const name = ref("");
const phone = ref("");
const registerEmail = ref("");
const collegeName = ref("");
const registerPassword = ref("");
const passwordConfirm = ref("");
const teamCode = ref("");
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const loader = ref(false);
const loginBtnText = ref("Sign in");
const registerBtnText = ref("Sign up");
const errors = ref({});

const close = () => {
    emit("update:modelValue", false);
};

const resetForms = () => {
    errors.value = {};
    email.value = "";
    password.value = "";
    name.value = "";
    phone.value = "";
    registerEmail.value = "";
    collegeName.value = "";
    registerPassword.value = "";
    passwordConfirm.value = "";
    teamCode.value = "";
    showPassword.value = false;
    showConfirmPassword.value = false;
    loader.value = false;
    loginBtnText.value = t("Sign in");
    registerBtnText.value = t("Sign up");
};

const switchTab = (tab) => {
    activeTab.value = tab;
    errors.value = {};
};

const loginUser = async () => {
    try {
        loader.value = true;
        loginBtnText.value = t("Signing in...");
        errors.value = {};

        const response = await axios.post(`/login`, {
            email: email.value,
            password: password.value,
        });

        authStore.setAuthData(response.data.data.token, response.data.data.user);

        Swal.fire({
            icon: "success",
            title: t("Success"),
            text: t("Login successful"),
            showConfirmButton: false,
            timer: 1200,
        });

        emit("success");
        close();
    } catch (error) {
        loader.value = false;
        loginBtnText.value = t("Sign in");

        if (error?.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            Swal.fire({
                icon: "error",
                title: t("Oops..."),
                text: error.response?.data?.message || t("Login failed. Please try again."),
            });
        }
    }
};

const registerUser = async () => {
    try {
        loader.value = true;
        registerBtnText.value = t("Signing up...");
        errors.value = {};

        const response = await axios.post(`/register`, {
            name: name.value,
            college_name: collegeName.value,
            phone: phone.value,
            email: registerEmail.value,
            password: registerPassword.value,
            password_confirmation: passwordConfirm.value,
            team_code: teamCode.value || undefined,
        });

        authStore.setAuthData(response.data.data.token, response.data.data.user);

        Swal.fire({
            icon: "success",
            title: t("Success"),
            text: t("Registration successful"),
            showConfirmButton: false,
            timer: 1200,
        });

        emit("success");
        close();
    } catch (error) {
        loader.value = false;
        registerBtnText.value = t("Sign up");

        if (error?.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            Swal.fire({
                icon: "error",
                title: t("Oops..."),
                text: error.response?.data?.message || t("Registration failed. Please try again."),
            });
        }
    }
};

watch(
    () => props.modelValue,
    (open) => {
        if (open) {
            activeTab.value = "login";
            resetForms();
        }
    }
);
</script>
