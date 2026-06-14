<template>
    <span class="animated-text accent" :style="trackStyle" aria-live="polite">
        <Transition name="animated-text" mode="out-in">
            <span :key="words[currentIndex]" class="animated-text__word">
                {{ words[currentIndex] }}
            </span>
        </Transition>
    </span>
</template>

<style scoped lang="scss">
.animated-text {
    display: inline-block;
    position: relative;
    vertical-align: bottom;
    text-align: left;
    background: linear-gradient(90deg, #15803d, #22c55e, #4ade80, #22c55e, #15803d);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animated-text-shimmer 4s linear infinite;
}

.animated-text__word {
    display: inline-block;
    white-space: nowrap;
}

.animated-text-enter-active,
.animated-text-leave-active {
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.animated-text-enter-from {
    opacity: 0;
    transform: translateY(0.85em);
}

.animated-text-leave-to {
    opacity: 0;
    transform: translateY(-0.85em);
}

@keyframes animated-text-shimmer {
    0% {
        background-position: 0% center;
    }
    100% {
        background-position: 200% center;
    }
}
</style>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue";

const props = defineProps({
    words: {
        type: Array,
        required: true,
        validator: (value) => value.length > 0,
    },
    interval: {
        type: Number,
        default: 2800,
    },
});

const currentIndex = ref(0);
let timer = null;

const trackStyle = computed(() => {
    const longest = props.words.reduce(
        (max, word) => (String(word).length > max.length ? String(word) : max),
        ""
    );

    return {
        minWidth: `${Math.max(longest.length, 1)}ch`,
    };
});

onMounted(() => {
    if (props.words.length <= 1) {
        return;
    }

    timer = window.setInterval(() => {
        currentIndex.value = (currentIndex.value + 1) % props.words.length;
    }, props.interval);
});

onBeforeUnmount(() => {
    if (timer !== null) {
        window.clearInterval(timer);
    }
});
</script>
