<template>
    <div
        class="course-video-player protected-media"
        @contextmenu.prevent
        @dragstart.prevent
    >
        <video
            ref="videoRef"
            class="course-video-player__video rounded w-100"
            :src="src"
            controls
            controlslist="nodownload noplaybackrate noremoteplayback"
            disablepictureinpicture
            disableremoteplayback
            preload="metadata"
            :autoplay="autoplay"
            @ratechange="onRateChange"
            @play="$emit('play')"
            @pause="$emit('pause')"
        ></video>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch, nextTick } from "vue";
import { attachNativeMediaProtection, lockElementPlaybackRate } from "@/composables/useProtectedMedia";

const props = defineProps({
    src: {
        type: String,
        required: true,
    },
    autoplay: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["play", "pause"]);

const videoRef = ref(null);
let detachProtection = () => {};

const onRateChange = () => {
    lockElementPlaybackRate(videoRef.value);
};

const bindProtection = () => {
    detachProtection();
    detachProtection = attachNativeMediaProtection(videoRef.value);
};

onMounted(bindProtection);

watch(
    () => videoRef.value,
    () => {
        bindProtection();
    }
);

watch(
    () => props.src,
    () => {
        nextTick(bindProtection);
    }
);

onBeforeUnmount(() => {
    detachProtection();
});

const play = () => videoRef.value?.play();
const pause = () => videoRef.value?.pause();

defineExpose({
    play,
    pause,
    videoElement: videoRef,
});
</script>

<style lang="scss" scoped>
.course-video-player {
    width: 100%;

    &__video {
        display: block;
        max-height: 70vh;
        background: #000;
        user-select: none;
        -webkit-user-select: none;
    }
}
</style>
