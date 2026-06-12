<template>
    <div class="protected-audio" @contextmenu.prevent @dragstart.prevent>
        <audio
            ref="audioRef"
            :src="src"
            controls
            controlslist="nodownload noplaybackrate"
            class="w-100"
            @play="$emit('play')"
            @pause="$emit('pause')"
        ></audio>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from "vue";
import { attachNativeMediaProtection } from "@/composables/useProtectedMedia";

defineProps({
    src: {
        type: String,
        required: true,
    },
});

defineEmits(["play", "pause"]);

const audioRef = ref(null);
let detachProtection = () => {};

const bindProtection = () => {
    detachProtection();
    detachProtection = attachNativeMediaProtection(audioRef.value);
};

onMounted(bindProtection);

watch(
    () => audioRef.value,
    () => {
        bindProtection();
    }
);

onBeforeUnmount(() => {
    detachProtection();
});

defineExpose({
    play: () => audioRef.value?.play(),
    pause: () => audioRef.value?.pause(),
    audioElement: audioRef,
});
</script>

<style scoped>
.protected-audio {
    user-select: none;
    -webkit-user-select: none;
}
</style>
