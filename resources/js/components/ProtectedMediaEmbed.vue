<template>
    <div
        ref="containerRef"
        class="protected-media-embed"
        @contextmenu.prevent
        @dragstart.prevent
        v-html="processedEmbed"
    ></div>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from "vue";
import {
    attachEmbeddedMediaProtection,
    processEmbedHtml,
} from "@/composables/useProtectedMedia";

const props = defineProps({
    embedHtml: {
        type: String,
        default: "",
    },
});

const containerRef = ref(null);
const processedEmbed = computed(() => processEmbedHtml(props.embedHtml));
let detachProtection = () => {};

const initProtection = async () => {
    await nextTick();
    detachProtection();
    detachProtection = await attachEmbeddedMediaProtection(containerRef.value);
};

onMounted(initProtection);

watch(
    () => props.embedHtml,
    () => {
        initProtection();
    }
);

onBeforeUnmount(() => {
    detachProtection();
});
</script>

<style lang="scss" scoped>
.protected-media-embed {
    width: 100%;
    user-select: none;
    -webkit-user-select: none;

    :deep(.protected-media-embed__iframe),
    :deep(.protected-media-embed__video) {
        display: block;
        width: 100%;
        min-height: 360px;
        border: 0;
        border-radius: 0.5rem;
        background: #000;
    }
}
</style>
