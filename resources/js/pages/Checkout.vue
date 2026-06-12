<template>
    <section class="container">
        <section class="checkout-wizard theme-shadow">
            <h3 class="fw-bold px-5 py-4 border-bottom mb-0">{{ $t('Checkout') }}</h3>
            <div class="row">
                <div :class="course?.is_free
                    ? 'col-12'
                    : 'col-12 col-lg-8 border-end p-4 ps-4 ps-lg-5'
                    ">
                    <div class="border rounded-3 p-2 p-lg-4 mb-4">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <img :src="course?.thumbnail" width="100%" alt="" height="140px"
                                    class="object-fit-cover rounded-3" />
                            </div>
                            <div class="col-12 col-lg-8">
                                <h5 class="mt-4 mt-lg-0">
                                    {{ course?.title }}
                                </h5>
                                <div class="d-flex mt-3 pb-3">
                                    <img :src="course?.instructor
                                        ?.profile_picture
                                        " class="rounded-circle object-fit-cover me-3" height="30px" width="30px" />
                                    <div>
                                        <span class="d-block">{{
                                            course?.instructor?.name
                                            }}</span>
                                    </div>
                                </div>
                                <div>
                                    <i class="bi bi-star-fill text-warning me-2"></i>
                                    <strong>{{
                                        course?.average_rating
                                        }}</strong>
                                    <span class="text-muted ms-2">({{
                                        course?.review_count
                                        }}
                                        {{ $t('Reviews') }})</span>
                                    <span class="text-muted mx-1">
                                        <i class="bi bi-dot"></i>
                                    </span>
                                    <span class="text-muted">{{
                                        course?.student_count
                                        }}
                                        {{ $t('Enrolled') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-3 p-2 p-lg-4">
                        <h5 class="mb-4">{{ $t('Order Details') }}</h5>
                        <div class="bg-light rounded-3 p-4">
                            <div class="price-breakdown mb-3">
                                <div class="d-flex justify-content-between mb-4" v-if="course?.price">
                                    <span>{{ $t('Course Price') }}</span>
                                    <strong>{{
                                        masterStore?.masterData
                                            ?.currency_symbol
                                    }}{{
                                            course?.is_free
                                                ? 0
                                                : course?.price
                                        }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-4" v-else>
                                    <span>{{ $t('Course Price') }}</span>
                                    <strong>{{
                                        masterStore?.masterData
                                            ?.currency_symbol
                                    }}{{
                                            course?.is_free
                                                ? 0
                                                : course?.regular_price
                                        }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-4 text-danger">
                                    <span>{{ $t('Discount') }}</span>
                                    <strong>-{{
                                        masterStore?.masterData
                                            ?.currency_symbol
                                    }}{{ discountAmount }}
                                    </strong>
                                </div>
                                <div class="mb-3">
                                    <span v-if="!showCouponInput" @click="showCouponInput = true"
                                        class="text-primary text-decoration-underline cursor-pointer">
                                        {{ $t('Have any coupon') }}?</span>
                                </div>
                                <form @submit.prevent="validateCoupon" v-if="!couponApplied && showCouponInput"
                                    class="bg-white d-flex rounded-3 p-4 mb-3">
                                    <input type="text" v-model="couponCode" class="form-control me-3"
                                        placeholder="Enter coupon code" />
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t('Apply') }}
                                    </button>
                                </form>

                                <div v-if="couponApplied" class="d-flex justify-content-between mb-3">
                                    <div>
                                        <i class="ri-checkbox-circle-fill text-success me-1"></i>
                                        <span class="me-3">{{ $t('Coupon Applied') }}</span>
                                        <small @click="
                                            couponApplied = false;
                                        showCouponInput = true;
                                        couponCode = null;
                                        " class="text-success bg-lightgreen px-2 py-1 rounded cursor-pointer">{{
                                            couponCode }}
                                            <i class="ri-edit-line"></i></small>
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-3">
                                    <label class="form-label fw-semibold">{{ $t('Class Mode') }} <span class="text-danger">*</span></label>
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <div @click="selectedClassMode = 'online'"
                                                :class="['card', 'class-mode-card', 'd-flex', 'align-items-center', 'gap-2', 'p-3', selectedClassMode === 'online' ? 'selected' : '']">
                                                <i class="bi bi-laptop fs-5"></i>
                                                <div>
                                                    <strong class="d-block">{{ $t('Online Class') }}</strong>
                                                    <small class="text-muted">{{ $t('Learn remotely') }}</small>
                                                </div>
                                                <input class="form-check-input ms-auto" type="radio"
                                                    :checked="selectedClassMode === 'online'">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div @click="selectedClassMode = 'offline'"
                                                :class="['card', 'class-mode-card', 'd-flex', 'align-items-center', 'gap-2', 'p-3', selectedClassMode === 'offline' ? 'selected' : '']">
                                                <i class="bi bi-building fs-5"></i>
                                                <div>
                                                    <strong class="d-block">{{ $t('Offline Class') }}</strong>
                                                    <small class="text-muted">{{ $t('Attend in person') }}</small>
                                                </div>
                                                <input class="form-check-input ms-auto" type="radio"
                                                    :checked="selectedClassMode === 'offline'">
                                            </div>
                                        </div>
                                    </div>

                                    <label class="form-label fw-semibold">{{ $t('Team Code') }} <span class="text-muted fw-normal">({{ $t('optional') }})</span></label>
                                    <div class="d-flex gap-2 mb-2">
                                        <input type="text" v-model="teamCode" class="form-control" maxlength="4"
                                            :placeholder="$t('Enter 4-character team code (optional)')" @blur="validateTeamCode" />
                                        <button type="button" class="btn btn-outline-primary" @click="validateTeamCode">
                                            {{ $t('Verify') }}
                                        </button>
                                    </div>
                                    <small v-if="teamValidated" class="text-success">
                                        <i class="ri-checkbox-circle-fill"></i> {{ validatedTeamName }}
                                    </small>
                                    <small v-else-if="teamCodeError" class="text-danger">{{ teamCodeError }}</small>

                                    <div v-if="teamMembers.length" class="mt-3">
                                        <label class="form-label fw-semibold">{{ $t('Counselor') }} <span class="text-muted fw-normal">({{ $t('optional') }})</span></label>
                                        <select v-model="selectedCounselorId" class="form-select">
                                            <option value="">{{ $t('Select counselor') }}</option>
                                            <option v-for="member in teamMembers" :key="member.id" :value="member.id">
                                                {{ member.name }}{{ member.is_leader ? ' (Team Leader)' : '' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between flex-wrap">
                                <span>
                                    <span class="fw-bold me-1">{{ $t('Subtotal') }}</span>
                                    <span>({{ $t('Payable') }})</span>
                                </span>
                                <span class="fw-bold">{{
                                    masterStore?.masterData
                                        ?.currency_symbol
                                }}{{ grandTotal.toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-center" v-if="course?.is_free">
                        <button @click="freeEnrollment"
                            class="d-flex justify-content-center gap-2 btn btn-primary rounded-pill fw-bold w-50">
                            Enroll Now
                            <i class="bi bi-arrow-right float-end"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-lg-4 ps-0 d-flex flex-column pt-3" v-if="!course?.is_free">
                    <div class="p-2">
                        <div class="d-flex justify-content-end align-items-center mb-4 px-3">
                            <small class="bg-lightgreen text-success rounded px-2 py-1 text-center">
                                <i class="ri-shield-check-fill me-1"></i>
                                {{ $t('100% Secure Payment') }}
                            </small>
                        </div>

                        <div class="payment-method-container p-3 rounded" style="background: #F1F5F9;">
                            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-2 g-3">
                                <div v-for="gateway in masterStore?.masterData?.payment_methods" :key="gateway.id"
                                    class="col">
                                    <div @click="selectedPaymentMethod = gateway.gateway"
                                        :class="['card', 'payment-card', 'd-flex', 'flex-row', 'justify-content-between', 'align-items-center', 'px-2 py-1', selectedPaymentMethod == gateway.gateway ? 'selected' : '']">
                                        <img :src="gateway.logo" class="payment-logo" alt="Payment method logo">
                                        <input class="form-check-input" type="radio"
                                            :checked="selectedPaymentMethod == gateway.gateway">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top p-4 d-flex align-items-start gap-3">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required
                            @change="acceptTerms = !acceptTerms" />
                        <label class="form-check-label" for="exampleCheck1">
                            {{ $t('By proceeding, you agree to the') }}
                            <router-link to="/page/terms_and_conditions"
                                class="text-decoration-none bg-transparent border-0 text-primary">
                                {{ $t('Terms & Condition') }}</router-link>,<router-link to="/page/privacy_policy"
                                class="text-decoration-none bg-transparent border-0 text-primary">
                                {{ $t('Privacy Policy') }}</router-link>
                            {{ $t('and') }}
                            <router-link to="/page/refund_policy"
                                class="text-decoration-none bg-transparent border-0 text-primary">
                                {{ $t('Refund Policy') }}</router-link> of {{ masterStore?.masterData?.name }}
                        </label>
                    </div>

                    <div class="mt-auto border-top p-4" v-if="!course?.is_enrolled">
                        <button @click="handleButtonClick" class="btn btn-primary rounded-pill fw-bold w-100">
                            {{ $t('Pay') }} {{ masterStore?.masterData?.currency_symbol
                            }}{{ grandTotal.toFixed(2) }}
                            <i class="bi bi-arrow-right float-end"></i>
                        </button>
                    </div>
                    <div class="mt-auto border-top p-4" v-else>
                        <button disabled class="btn btn-primary rounded-pill fw-bold w-100">
                            {{ $t('Already Enrolled') }}
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>

<style scoped>
.checkout-wizard {
    border-radius: 2rem;
    box-shadow: 0px 16px 64px 0px #306c3c14;

    .price-breakdown {
        border-bottom: 2px dashed #ccc;
    }

    .payment-method {
        cursor: pointer;

        &:hover {
            border-color: #306c3c !important;
        }
    }

    .payment-method.selected {
        border-color: #306c3c !important;
    }
}

.payment-method {
    margin-right: 12px;
    cursor: pointer;

    &:hover {
        border-color: #306c3c !important;
    }
}

.payment-method.selected {
    border-color: #306c3c !important;
}

.payment-method-container .payment-logo {
    width: 100px;
    height: 70px;
    object-fit: contain;
    padding: 0 !important;
}

.class-mode-card {
    cursor: pointer;
    border: 2px solid #e2e8f0;
    transition: border-color 0.2s;

    &:hover,
    &.selected {
        border-color: #306c3c;
    }
}

.payment-card.selected {
    border-color: #306c3c !important;
}
</style>

<script setup>
import { onMounted, ref, watch } from "vue";
import Header from "../components/Header.vue";
import { useMasterStore } from "@/stores/master";
import { useAuthStore } from "@/stores/auth";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";
import Swal from "sweetalert2";

const masterStore = useMasterStore();
const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();

const course_id = route.params.id;
const selectedClassMode = ref("online");
const selectedPaymentMethod = ref("");

const course = ref({});
const discountAmount = ref(0);
const grandTotal = ref(0);
const showCouponInput = ref(false);
const couponCode = ref("");
const couponApplied = ref(false);
const teamCode = ref("");
const teamValidated = ref(false);
const validatedTeamName = ref("");
const teamCodeError = ref("");
const teamMembers = ref([]);
const selectedCounselorId = ref("");
let acceptTerms = ref(false);

watch(
    () => discountAmount.value,
    () => {
        if (course.value.is_free) {
            grandTotal.value = 0;
        } else if (course.value.regular_price && !course.value.price) {
            grandTotal.value =
                course.value.regular_price - discountAmount.value;
        } else {
            grandTotal.value = course.value.price - discountAmount.value;
        }
    }
);

const selectDefaultPaymentMethod = () => {
    const methods = masterStore?.masterData?.payment_methods ?? [];
    const activeGateways = methods.map((method) => method.gateway);

    if (selectedPaymentMethod.value && !activeGateways.includes(selectedPaymentMethod.value)) {
        selectedPaymentMethod.value = "";
    }
};

watch(
    () => masterStore?.masterData?.payment_methods,
    () => selectDefaultPaymentMethod(),
    { immediate: true }
);

const validateCoupon = async () => {
    try {
        const response = await axios.get(`/coupon/validate`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${authStore.authToken}`,
            },
            params: {
                coupon_code: couponCode.value,
            },
        });

        discountAmount.value = response.data.data.discount;

        couponApplied.value = true;

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
        Toast.fire({
            icon: "success",
            title: "Coupon applied successfully",
        });
    } catch (error) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
        Toast.fire({
            icon: "error",
            title: "Oops...",
            text: "Coupon code is invalid",
        });
    }
};

const validateTeamCode = async () => {
    teamCodeError.value = "";
    teamValidated.value = false;
    teamMembers.value = [];
    selectedCounselorId.value = "";
    validatedTeamName.value = "";

    if (!teamCode.value || teamCode.value.length !== 4) {
        if (teamCode.value) {
            teamCodeError.value = "Team code must be exactly 4 characters";
        }
        return;
    }

    try {
        const response = await axios.get(`/sales-team/validate`, {
            headers: {
                Accept: "application/json",
            },
            params: {
                team_code: teamCode.value,
            },
        });

        teamValidated.value = true;
        validatedTeamName.value = response.data.data.team.name;
        teamMembers.value = response.data.data.team.members || [];
    } catch (error) {
        teamCodeError.value = error.response?.data?.message || "Invalid team code";
    }
};

const fetchCourseData = async () => {
    try {
        const response = await axios.get(`/course/show/${course_id}`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${authStore.authToken}`,
            },
        });
        course.value = response.data.data.course;
        // grandtotal measurement start
        if (course.value.is_free) {
            grandTotal.value = 0;
        } else if (course.value.regular_price && !course.value.price) {
            grandTotal.value =
                course.value.regular_price - discountAmount.value;
        } else {
            grandTotal.value = course.value.price - discountAmount.value;
        }
        // grandtotal measurement end
    } catch (error) {
        console.error("Error fetching course data:", error);
    }
};

const handleButtonClick = () => {
    if (!selectedClassMode.value) {
        Swal.fire({
            icon: "error",
            title: "Class mode required",
            text: "Please select Online Class or Offline Class.",
        });
        return;
    }

    if (acceptTerms.value && selectedPaymentMethod.value) {
        initiateTransaction();
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "bottom-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
        Toast.fire({
            icon: "error",
            title: "Oops...",
            text: "Please select a payment method and agree to the terms and conditions",
        });
    }
}

const initiateTransaction = async () => {
    if (course.value.is_free) {
        grandTotal.value = 0;
    } else if (course.value.regular_price && !course.value.price) {
        grandTotal.value = course.value.regular_price - discountAmount.value;
    } else {
        grandTotal.value = course.value.price - discountAmount.value;
    }


    if (selectedPaymentMethod.value == "stripe" || selectedPaymentMethod.value == "paypal" || selectedPaymentMethod.value == "razorpay") {

        if (masterStore?.masterData?.currency != "USD" && grandTotal.value < masterStore?.masterData?.minimum_amount) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
            });
            Toast.fire({
                icon: "error",
                title: "Oops...",
                text: `Please note that a minimum of grand total of ${masterStore?.masterData?.minimum_amount} is required for transaction.`,
            });
            return;
        }

        if (masterStore?.masterData?.currency == "BDT") {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
            });
            Toast.fire({
                icon: "error",
                title: "Oops...",
                text: `BDT is not supported at the moment`,
            });
            return;
        }
    }

    try {
        const response = await axios.get(`/enroll/${course_id}`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${authStore.authToken}`,
            },
            params: {
                payment_gateway: selectedPaymentMethod.value,
                class_mode: selectedClassMode.value,
                coupon_code: couponCode.value,
                team_code: teamValidated.value ? teamCode.value : undefined,
                sales_team_member_id: selectedCounselorId.value || undefined,
                total_amount: grandTotal.value,
            },
        });

        openPaymentPopupWindow(response.data.data.payment_webview_url);
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text:
                error.response?.data?.message ||
                "Something went wrong. Please try again.",
        });
    }
};

const freeEnrollment = async () => {
    if (!selectedClassMode.value) {
        Swal.fire({
            icon: "error",
            title: "Class mode required",
            text: "Please select Online Class or Offline Class.",
        });
        return;
    }

    try {
        const response = await axios.get(`/free/enroll/${course_id}`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${authStore.authToken}`,
            },
            params: {
                class_mode: selectedClassMode.value,
            },
        });

        if (response?.data?.data?.status == "success") {
            let status = response?.data?.data?.status;
            router.push(
                `/enroll_status?status=${status}&course_id=${course_id}`
            );
        }
    } catch (error) {

        Swal.fire({
            icon: "error",
            title: "Oops...",
            text:
                error.response?.data?.message ||
                "Something went wrong. Please try again.",
        });
    }
};

onMounted(async () => {
    await fetchCourseData();
    localStorage.removeItem("handle_course_id");
});

const openPaymentPopupWindow = (url, debug = false) => {
    if (debug) console.log(`Opening payment window: ${url}`);

    const winWidth = 700;
    const winHeight = 700;
    const left = screen.width / 2 - winWidth / 2;
    const top = screen.height / 2 - winHeight / 2;

    const options = `resizable,height=${winHeight},width=${winWidth},top=${top},left=${left}`;
    const win = window.open(url, "_blank", options);
    if (!win) {
        if (debug) console.error("Failed to open payment window");
        return;
    }

    win.document.title = "Payment Window Screen - Make Payment";

    let intervalID = null;

    const handleWindowClose = (status) => {
        if (debug) console.log(`Closing with status: ${status}`);
        if (win && !win.closed) {
            win.close();
        }
        if (status === "success") {
            if (window.location.pathname !== "/dashboard") {
                window.location.href = "/dashboard";
            }
            return;
        }
        if (window.location.pathname !== "/enroll_status") {
            window.location.href = `/enroll_status?status=${status}&course_id=${course_id}`;
        }
    };

    const trackWindow = () => {
        try {
            if (win.closed) {
                if (debug) console.log("Window manually closed");
                clearInterval(intervalID);
                handleWindowClose("closed");
                return;
            }

            // Only do tracking if same-origin
            const currentHost = location.host;
            if (win.location.host === currentHost) {
                const pathname = win.location.pathname;
                if (pathname.includes("payment/success")) {
                    clearInterval(intervalID);
                    handleWindowClose("success");
                } else if (pathname.includes("payment/cancel")) {
                    clearInterval(intervalID);
                    handleWindowClose("cancel");
                } else if (pathname.includes("payment/fail")) {
                    clearInterval(intervalID);
                    handleWindowClose("fail");
                } else {
                    clearInterval(intervalID);
                    handleWindowClose("fail");
                }
            }

        } catch (e) {
            if (debug) console.warn("Cross-origin access blocked; cannot track status until redirect returns to same-origin.");
        }
    };

    intervalID = setInterval(trackWindow, 10);

    win.focus();
};
</script>
