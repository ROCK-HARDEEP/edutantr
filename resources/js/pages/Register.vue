<template>
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-900 via-green-800 to-emerald-900 relative overflow-y-auto py-8">
        <!-- Decorative background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-green-400/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-lg px-4 py-8 relative z-10">
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/10 border border-white/20 overflow-hidden relative">
                <!-- Version badge -->
                <div v-if="masterStore?.masterData?.mode == 'local'"
                    class="absolute top-0 right-0 bg-green-800 text-white text-sm font-bold px-5 py-1.5 rounded-bl-xl rounded-tr-xl shadow-md z-10">
                    v{{ masterStore?.masterData?.version }}
                </div>

                <!-- Logo -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5 flex justify-center">
                    <BrandLogo to="/" centered size="lg" />
                </div>

                <!-- Form area -->
                <div class="px-6 sm:px-8 py-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $t('Sign up') }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ $t('Sign in to continue with checkout') }}</p>

                    <form @submit.prevent="registerUser" class="space-y-4">
                        <!-- Full Name -->
                        <div>
                            <label for="reg-name" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Full Name') }}</label>
                            <InputText
                                id="reg-name"
                                type="text"
                                v-model="name"
                                :placeholder="$t('Full Name')"
                                class="w-full"
                                :class="{ 'p-invalid': errors?.name }"
                            />
                            <small v-if="errors?.name" class="text-red-500 font-semibold mt-1 block">{{ errors?.name[0] }}</small>
                        </div>

                        <!-- Phone & Email row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="reg-phone" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Phone Number') }}</label>
                                <InputText
                                    id="reg-phone"
                                    type="tel"
                                    v-model="phone"
                                    :placeholder="$t('Phone Number')"
                                    class="w-full"
                                    :class="{ 'p-invalid': errors?.phone }"
                                />
                                <small v-if="errors?.phone" class="text-red-500 font-semibold mt-1 block">{{ errors?.phone[0] }}</small>
                            </div>
                            <div>
                                <label for="reg-email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Email') }}</label>
                                <InputText
                                    id="reg-email"
                                    type="email"
                                    v-model="email"
                                    :placeholder="$t('Email')"
                                    class="w-full"
                                    :class="{ 'p-invalid': errors?.email }"
                                />
                                <small v-if="errors?.email" class="text-red-500 font-semibold mt-1 block">{{ errors?.email[0] }}</small>
                            </div>
                        </div>

                        <!-- College Name -->
                        <div>
                            <label for="reg-college" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('College / Institution Name') }}</label>
                            <InputText
                                id="reg-college"
                                type="text"
                                v-model="collegeName"
                                :placeholder="$t('College / Institution Name')"
                                class="w-full"
                                :class="{ 'p-invalid': errors?.college_name }"
                            />
                            <small v-if="errors?.college_name" class="text-red-500 font-semibold mt-1 block">{{ errors?.college_name[0] }}</small>
                        </div>

                        <!-- Password & Confirm row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="reg-password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Create Password') }}</label>
                                <Password
                                    id="reg-password"
                                    v-model="password"
                                    :placeholder="$t('Create Password')"
                                    :feedback="true"
                                    toggleMask
                                    class="w-full"
                                    inputClass="w-full"
                                    :class="{ 'p-invalid': errors?.password }"
                                />
                                <small v-if="errors?.password" class="text-red-500 font-semibold mt-1 block">{{ errors?.password[0] }}</small>
                            </div>
                            <div>
                                <label for="reg-confirm" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Confirm Password') }}</label>
                                <Password
                                    id="reg-confirm"
                                    v-model="passwordConfirm"
                                    :placeholder="$t('Confirm Password')"
                                    :feedback="false"
                                    toggleMask
                                    class="w-full"
                                    inputClass="w-full"
                                />
                            </div>
                        </div>

                        <!-- Team Code -->
                        <div>
                            <label for="reg-team" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('Team Code (4 characters, optional)') }}</label>
                            <InputText
                                id="reg-team"
                                type="text"
                                v-model="teamCode"
                                maxlength="4"
                                :placeholder="$t('Team Code (4 characters, optional)')"
                                class="w-full"
                                :class="{ 'p-invalid': errors?.team_code }"
                            />
                            <small v-if="errors?.team_code" class="text-red-500 font-semibold mt-1 block">{{ errors?.team_code[0] }}</small>
                        </div>

                        <!-- Terms checkbox -->
                        <div class="flex items-start gap-2.5">
                            <Checkbox v-model="acceptedTerms" inputId="terms-check" binary class="mt-0.5" />
                            <label for="terms-check" class="text-xs text-gray-500 leading-relaxed cursor-pointer">
                                {{ $t('I accept and agree to the') }}
                                <button type="button" @click="terms"
                                    class="text-green-700 hover:text-green-800 font-medium bg-transparent border-0 p-0 cursor-pointer text-xs">
                                    {{ $t('Terms & Condition') }}
                                </button>
                                {{ $t('and') }}
                                <button type="button" @click="policy"
                                    class="text-green-700 hover:text-green-800 font-medium bg-transparent border-0 p-0 cursor-pointer text-xs">
                                    {{ $t('Privacy Policy') }}
                                </button>
                                {{ $t('of') }} {{ masterStore?.masterData?.name }}
                            </label>
                        </div>

                        <!-- Submit -->
                        <Button
                            type="submit"
                            :label="signUpBtnText"
                            :loading="loader"
                            :disabled="!acceptedTerms"
                            class="w-full"
                            raised
                        />
                    </form>

                    <!-- Login link -->
                    <p class="text-center text-sm text-gray-500 mt-6 mb-2">
                        {{ $t('Already have an account') }}?
                        <router-link to="/login" class="text-green-700 hover:text-green-800 font-semibold transition-colors">
                            {{ $t('Log in') }}
                        </router-link>
                    </p>
                </div>

                <!-- Powered by -->
                <div v-if="masterStore?.masterData?.mode == 'local'"
                    class="absolute bottom-2.5 right-4 text-green-800 text-sm font-bold">
                    Powered by RazinSoft &copy;{{ new Date().getFullYear() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Policy Modal -->
    <Dialog v-model:visible="showPolicyModal" :header="$t('Privacy Policy')" modal :style="{ width: '50rem' }" :breakpoints="{ '575px': '95vw' }" class="policy-modal">
        <div class="text-sm text-gray-600 leading-relaxed" v-html="policyPage?.content"></div>
    </Dialog>

    <!-- Terms Modal -->
    <Dialog v-model:visible="showTermsModal" :header="$t('Terms & Condition')" modal :style="{ width: '50rem' }" :breakpoints="{ '575px': '95vw' }" class="terms-modal">
        <div class="text-sm text-gray-600 leading-relaxed" v-html="termsPage?.content"></div>
    </Dialog>
</template>

<script setup>
import BrandLogo from "@/components/BrandLogo.vue";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import Dialog from "primevue/dialog";
import { ref, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Swal from "sweetalert2";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";

const router = useRouter();
const authStore = useAuthStore();
const masterStore = useMasterStore();
const policyPage = ref(null);
const termsPage = ref(null);
const showPolicyModal = ref(false);
const showTermsModal = ref(false);
const acceptedTerms = ref(false);

const policy = () => {
    policyPage.value = masterStore.masterData.pages[0];
    showPolicyModal.value = true;
}
const terms = () => {
    termsPage.value = masterStore.masterData.pages[1];
    showTermsModal.value = true;
}

const name = ref("");
const collegeName = ref("");
const phone = ref("");
const email = ref("");
const password = ref("");
const passwordConfirm = ref("");
const teamCode = ref("");

// Watchers to clear errors when user inputs data
watch(name, (newValue) => {
    errors.value.name = newValue ? "" : errors.value.name;
});
watch(collegeName, (newValue) => {
    errors.value.college_name = newValue ? "" : errors.value.college_name;
});
watch(phone, (newValue) => {
    errors.value.phone = newValue ? "" : errors.value.phone;
});
watch(email, (newValue) => {
    errors.value.email = newValue ? "" : errors.value.email;
});
watch(password, (newValue) => {
    errors.value.password = newValue ? "" : errors.value.password;
});
watch(passwordConfirm, (newValue) => {
    errors.value.password_confirmation = newValue
        ? ""
        : errors.value.password_confirmation;
});

// for errors
let errors = ref();

const signUpBtnText = ref("Sign up");
const loader = ref(false);

// Function to handle user registration
const registerUser = async () => {
    try {
        loader.value = true;
        signUpBtnText.value = "Signing up...";
        const response = await axios.post(`/register`, {
            name: name.value,
            college_name: collegeName.value,
            phone: phone.value,
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirm.value,
            team_code: teamCode.value || undefined,
        });
        // Store user data and auth token in Pinia store
        authStore.setAuthData(
            response.data.data.token,
            response.data.data.user
        );
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Registration successful",
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
        signUpBtnText.value = "Sign up";
        errors.value = error.response?.data?.errors;
    }
};

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
