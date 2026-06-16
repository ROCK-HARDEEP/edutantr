<template>
    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200 pb-3 mb-3">
        <div class="w-full sm:w-1/4 p-4 border-r border-slate-200 text-center sm:text-left">
            <h3 class="font-bold text-2xl text-slate-800">{{ averageRating }}</h3>
            <div class="mb-2">
                <i v-for="star in 5" :key="star" class="bi" :class="{
                    'bi-star-fill text-amber-400 mr-1': star <= Math.floor(averageRating),
                    'bi-star-half text-amber-400 mr-1': star === Math.ceil(averageRating) && averageRating % 1 !== 0,
                    'bi-star text-slate-300 mr-1': star > Math.ceil(averageRating)
                }"></i>
            </div>
            <span class="text-slate-400 text-sm">
                {{ reviewCount }} {{ $t('reviews')}}
            </span>
        </div>
        <div class="w-full sm:w-3/4 px-4 sm:px-5">
            <div class="flex items-center gap-3" v-for="(rating, index) in [5, 4, 3, 2, 1]" :key="index">
                <div class="w-6 text-sm font-medium text-slate-600">
                    <span>{{ rating }}</span>
                </div>
                <div class="flex-1">
                    <div class="w-full bg-slate-100 rounded-full overflow-hidden" :aria-valuenow="getRatingPercentage(rating)" aria-valuemin="0"
                        aria-valuemax="100" style="height: 10px;">
                        <div class="bg-amber-400 h-full rounded-full" :style="{ width: getRatingPercentage(rating) + '%' }">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    courseData: Object
});

const averageRating = computed(() => {
    const totalRating = props?.courseData?.reviews?.reduce((sum, review) => sum + review.rating, 0);
    return (totalRating / props?.courseData?.reviews?.length).toFixed(1);
});

const reviewCount = computed(() => props?.courseData?.reviews?.length);

const getRatingPercentage = (ratingLevel) => {
    const totalReviews = props?.courseData?.reviews?.length;
    const count = props?.courseData?.reviews?.filter(review => review.rating === ratingLevel)?.length;
    return totalReviews > 0 ? (count / totalReviews) * 100 : 0;
};
</script>
