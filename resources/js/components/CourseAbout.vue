<template>
    <div
        v-for="(description, index) in descriptions"
        :key="index"
        class="p-3 bg-white rounded-xl mb-3"
    >
        <h5 class="font-bold text-slate-800">{{ description.heading }}</h5>
        <article v-html="description.body"></article>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    descriptions: Array,
});
</script>
