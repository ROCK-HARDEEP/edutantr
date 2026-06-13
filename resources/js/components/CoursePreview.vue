<template>
    <section>
        <div v-if="!showVideo" class="course-preview mb-4" :style="'background-image: url(' + course?.thumbnail + ');'">
            <span v-if="course?.video" @click="playVideo()" class="play-btn d-flex rounded-circle bg-primary px-2">
                <i class="bi bi-play-fill"></i>
            </span>
        </div>
        <CourseVideoPlayer
            v-if="showVideo"
            :src="course?.video"
            autoplay
        />
        <div class="p-3 rounded-3 mb-4 theme-shadow" style="background: #F1F5F9;">
            <div class="d-inline-block mb-4 me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ $t('Lifetime Course Access') }}</span>
            </div>

            <div class="d-inline-block mb-4 me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ course?.video_count }} {{ $t('Video Lectures')
                }}</span>
            </div>

            <div class="d-inline-block mb-4 me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ course?.audio_count }} {{ $t('Audio Content')
                }}</span>
            </div>

            <div class="d-inline-block mb-4 me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ course?.note_count }} {{ $t('Notes') }}</span>
            </div>

            <div class="d-inline-block me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ course?.free_video }} {{ $t('Free Videos')
                }}</span>
            </div>

            <div class="d-inline-block me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ course?.free_content }} {{ $t('Free Content')
                }}</span>
            </div>

            <div v-if="course?.certificate_available" class="d-inline-block me-2">
                <span class="bg-white px-2 py-2 text-muted rounded">{{ $t('Certificate Available') }}</span>
            </div>
        </div>

        <div v-if="!course?.is_free && !course?.is_enrolled" class="enroll-action border border-primary rounded-3 pt-3">
            <div class="text-center mb-4">
                <span class="d-block">{{ $t('Course Fee') }}</span>
                <div v-if="course?.price && course?.regular_price">
                    <strong v-if="masterStore?.masterData?.currency_position == 'Left'" class="fs-2 me-2">{{
                        masterStore?.masterData?.currency_symbol
                        }}{{ course?.price }}</strong>
                    <strong v-else class="fs-2 me-2">{{ course?.price
                        }}{{ masterStore?.masterData?.currency_symbol }}</strong>
                    <span v-if="masterStore?.masterData?.currency_position == 'Left'"
                        class="fs-3 text-muted text-decoration-line-through">{{ masterStore?.masterData?.currency_symbol
                        }}{{ course?.regular_price }}</span>
                    <span v-else class="fs-3 text-muted text-decoration-line-through">{{ course?.regular_price
                        }}{{ masterStore?.masterData?.currency_symbol }}</span>
                </div>
                <div v-else-if="!course?.price && course?.regular_price">
                    <strong v-if="masterStore?.masterData?.currency_position == 'Left'" class="fs-2 me-2">{{
                        masterStore?.masterData?.currency_symbol
                        }}{{ course?.regular_price }}</strong>
                    <strong v-else class="fs-2 me-2">{{ course?.regular_price
                        }}{{ masterStore?.masterData?.currency_symbol }}</strong>
                </div>
            </div>

            <router-link :to="'/checkout/' + course?.id" @click.prevent="handleRoute('full')"
                class="enroll-btn btn btn-primary py-3 w-100">{{ $t('Enroll Now') }}<i
                    class="bi bi-arrow-right ms-2"></i></router-link>
        </div>

        <div v-if="course?.pre_course_enabled && course?.pre_course_price && !course?.is_enrolled && !course?.is_pre_course_enrolled"
            class="pre-course-action border border-warning rounded-3 p-3 mt-3">
            <div class="text-center mb-3">
                <span class="badge bg-warning text-dark mb-2">{{ $t('Pre-Course Register') }}</span>
                <p class="text-muted small mb-2">{{ course?.pre_course_description }}</p>
                <strong v-if="masterStore?.masterData?.currency_position == 'Left'" class="fs-4">{{
                    masterStore?.masterData?.currency_symbol }}{{ course?.pre_course_price }}</strong>
                <strong v-else class="fs-4">{{ course?.pre_course_price }}{{
                    masterStore?.masterData?.currency_symbol }}</strong>
            </div>
            <router-link :to="'/checkout/' + course?.id + '?type=pre_course'" @click.prevent="handleRoute('pre_course')"
                class="btn btn-outline-warning w-100 py-2">
                {{ $t('Pre-Register Now') }}<i class="bi bi-arrow-right ms-2"></i>
            </router-link>
        </div>

        <div v-if="course?.is_pre_course_enrolled && !course?.is_enrolled"
            class="pre-course-enrolled border border-info rounded-3 p-3 mt-3 text-center">
            <span class="badge bg-info text-dark mb-2">{{ $t('Pre-Registered') }}</span>
            <p class="text-muted small mb-3">{{ $t('You have pre-registered for this course. Complete full enrollment to access all lessons.') }}</p>
            <router-link :to="'/checkout/' + course?.id" @click.prevent="handleRoute('full')"
                class="btn btn-primary w-100 py-2">
                {{ $t('Complete Full Enrollment') }}<i class="bi bi-arrow-right ms-2"></i>
            </router-link>
        </div>

        <router-link v-else-if="course?.is_free || course?.is_enrolled" :to="course?.check_subscription
            ? '/dashboard/plan-renewal-history?plan_id=' + course?.current_plan_id
            : (course?.is_enrolled && !course?.check_subscription)
                ? '/play/' + course?.id
                : '/checkout/' + course?.id" @click.prevent="handleWaring" class="btn btn-primary w-100">
            {{
                course?.check_subscription
                    ? $t('Subscribe Now')
                    : (course?.is_enrolled && !course?.check_subscription)
                        ? $t('Play Now')
                        : $t('Enroll Now')
            }}
        </router-link>
    </section>
</template>

<style lang="scss" scoped>
.course-preview {
    height: 225px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2rem;
    font-weight: bold;

    .play-btn {
        cursor: pointer;
        border: 5px solid #ffffffbd;
        border-radius: 50%;
    }
}

.student-count {
    background-color: #f0ffef;
}

.lesson-count {
    background-color: #fff6f5;
}

.resource-count {
    background-color: #f3f9ff;
}

.enroll-action {
    background-color: #f0f7f2;

    .enroll-btn {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
    }
}

.pre-course-action {
    background-color: #fffbf0;
}

.pre-course-enrolled {
    background-color: #f0f9ff;
}
</style>

<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";
import CourseVideoPlayer from "@/components/CourseVideoPlayer.vue";

const authStore = useAuthStore();
const masterStore = useMasterStore();
const router = useRouter();

let props = defineProps({
    course: Object,
    chapters: Array,
});

const showVideo = ref(false);

function playVideo() {
    showVideo.value = true;
}

const handleRoute = (type = 'full') => {
    const query = type === 'pre_course' ? { type: 'pre_course' } : {};
    router.push({ path: "/checkout/" + props.course?.id, query });
};

const handleWaring = () => {
    const target = props.course?.check_subscription
        ? "/dashboard/plan-renewal-history?plan_id=" + props.course?.current_plan_id
        : props.course?.is_enrolled && !props.course?.check_subscription
            ? "/play/" + props.course?.id
            : "/checkout/" + props.course?.id;

    if (!authStore.userData && target.startsWith("/play")) {
        Swal.fire({
            icon: "error",
            title: "Sorry...",
            text: "You need to log in to access this page.",
            confirmButtonText: "Go to Login",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/login";
            }
        });
        return;
    }

    router.push(target);
};


onMounted(() => {
    localStorage.removeItem("handle_course_id");
});



</script>
