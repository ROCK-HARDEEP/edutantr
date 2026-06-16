<template>
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-900 via-green-800 to-emerald-900 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-green-400/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-md px-4 py-8 relative z-10">
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/10 border border-white/20 overflow-hidden relative">
                <!-- Version badge -->
                <div v-if="masterStore?.masterData?.mode == 'local'"
                    class="absolute top-0 right-0 bg-green-800 text-white text-sm font-bold px-5 py-1.5 rounded-bl-xl rounded-tr-xl shadow-md">
                    v{{ masterStore?.masterData?.version }}
                </div>

                <!-- Logo -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5 flex justify-center">
                    <BrandLogo to="/" centered size="lg" />
                </div>

                <!-- Form area -->
                <div class="px-6 sm:px-8 py-6">
                    <!-- Back to home -->
                    <router-link to="/"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-green-700 hover:text-green-800 mb-4 transition-colors">
                        <FontAwesomeIcon :icon="faArrowLeft" class="text-xs" />
                        {{ $t('Go to Home Page') }}
                    </router-link>

                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $t('Login') }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ $t('Boost your skill always and forever') }}.</p>

                    <form @submit.prevent="loginUser" class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label for="login-email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Email Address') }}</label>
                            <InputText
                                id="login-email"
                                type="email"
                                v-model="email"
                                :placeholder="$t('Email Address')"
                                class="w-full"
                                :class="{ 'p-invalid': errors.email }"
                            />
                            <small v-if="errors.email" class="text-red-500 font-semibold mt-1 block">{{ errors.email[0] }}</small>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="login-password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Password') }}</label>
                            <Password
                                id="login-password"
                                v-model="password"
                                :placeholder="$t('Password')"
                                :feedback="false"
                                toggleMask
                                class="w-full"
                                inputClass="w-full"
                                :class="{ 'p-invalid': errors.password }"
                            />
                            <small v-if="errors.password" class="text-red-500 font-semibold mt-1 block">{{ errors.password[0] }}</small>
                        </div>

                        <!-- Forgot password -->
                        <div class="flex justify-end">
                            <router-link to="/reset_password" class="text-sm text-green-700 hover:text-green-800 font-medium transition-colors">
                                {{ $t('Forgot your password') }}?
                            </router-link>
                        </div>

                        <!-- Submit -->
                        <Button
                            type="submit"
                            :label="loginBtnText"
                            :loading="loader"
                            class="w-full"
                            raised
                        />
                    </form>

                    <!-- Sign up link -->
                    <p class="text-center text-sm text-gray-500 mt-6">
                        {{ $t("Don't have an account") }}?
                        <router-link to="/register" class="text-green-700 hover:text-green-800 font-semibold transition-colors">
                            {{ $t('Sign Up') }}
                        </router-link>
                    </p>

                    <!-- Demo credentials (local mode) -->
                    <div v-if="masterStore?.masterData?.mode == 'local'"
                        class="mt-4 border border-gray-200 rounded-xl p-4 flex flex-wrap gap-3 items-center justify-between bg-gray-50">
                        <div class="text-sm">
                            <strong class="text-gray-700">{{ $t('Email') }}:</strong> user@readylms.com <br>
                            <strong class="text-gray-700">{{ $t('Password') }}:</strong> secret@123
                        </div>
                        <Button
                            @click="copyDemoCredentials('user@readylms.com', 'secret@123')"
                            :label="$t('Copy')"
                            size="small"
                            outlined
                            severity="secondary"
                        />
                    </div>
                </div>

                <!-- Powered by -->
                <div v-if="masterStore?.masterData?.mode == 'local'"
                    class="absolute bottom-2.5 right-4 text-green-800 text-sm font-bold">
                    Powered by RazinSoft &copy;{{ new Date().getFullYear() }}
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import BrandLogo from "@/components/BrandLogo.vue";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import axios from "axios";
import Swal from "sweetalert2";
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";
import { useI18n } from "vue-i18n";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";

let errors = ref("");
const loader = ref(false);

const router = useRouter();
const authStore = useAuthStore();
const masterStore = useMasterStore();

const email = ref("");
const password = ref("");
const loginBtnText = ref("Sign in");
const { t } = useI18n();

// Function to handle login
const loginUser = async () => {
    try {
        loader.value = true;
        loginBtnText.value = "Signing in...";
        const response = await axios.post(`/login`, {
            email: email.value,
            password: password.value,
        });

        // Store user data and auth token in state
        authStore.setAuthData(
            response.data.data.token,
            response.data.data.user
        );

        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Login successful",
            showConfirmButton: false,
            timer: 1500,
        });

        // Redirect to dashboard or other page
        if (localStorage.getItem("handle_course_id")) {
            router.push("/checkout/" + localStorage.getItem("handle_course_id"));
            localStorage.removeItem("handle_course_id");
        } else {
            router.push("/dashboard");
        }

    } catch (error) {
        loader.value = false;
        if (error?.response?.data.errors) {
            errors.value = error?.response?.data.errors;
        } else {
            errors.value = error?.response?.data.message;
        }

        loginBtnText.value = "Sign in";

        if (error?.response?.status === 403) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                    error.response?.data?.message ||
                    "Login failed. Please try again.",
            });
        }
    }
};


const copyDemoCredentials = (demoEmail, demoPassword) => {
    email.value = demoEmail
    password.value = demoPassword

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "success",
        title: t("Demo credentials copied Successfully!!")
    });
}


onMounted(async () => {
    if (!masterStore.data) {
        axios
            .get(`/master`, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            })
            .then((response) => {
                masterStore.setMasterData(response.data.data.master);
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
})

</script>

<style>
/* Override PrimeVue Password input wrapper to fill width */
.p-password {
    width: 100%;
}
.p-password input {
    width: 100%;
}
.p-button.p-button-raised {
    box-shadow: 0 4px 14px 0 rgba(22, 163, 74, 0.39);
}
</style>
