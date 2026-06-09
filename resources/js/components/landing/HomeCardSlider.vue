<template>
    <swiper
        v-if="items.length"
        :modules="[Navigation, Pagination, Autoplay]"
        :space-between="15"
        :breakpoints="breakpoints"
        navigation
        pagination
        autoplay
        loop
        :class="items.length < 4 ? 'centeredSlider' : ''"
    >
        <swiper-slide v-for="(item, index) in items" :key="index" class="mb-5 py-4">
            <slot :item="item" :index="index" />
        </swiper-slide>
    </swiper>
    <p v-else class="text-center text-muted py-4">{{ emptyText }}</p>
</template>

<style>
.centeredSlider .swiper-wrapper {
    justify-content: center;
}
@media (max-width: 767px) {
    .centeredSlider .swiper-wrapper {
        justify-content: flex-start;
    }
}
</style>

<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";

defineProps({
    items: { type: Array, default: () => [] },
    emptyText: { type: String, default: "" },
    breakpoints: {
        type: Object,
        default: () => ({
            320: { slidesPerView: 1, spaceBetween: 10 },
            576: { slidesPerView: 2, spaceBetween: 15 },
            992: { slidesPerView: 3, spaceBetween: 20 },
            1200: { slidesPerView: 4, spaceBetween: 20 },
        }),
    },
});
</script>
