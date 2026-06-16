<template>
    <div class="w-full" :class="{ 'px-0 overflow-hidden max-w-full': compact }">
        <swiper
            :slides-per-view="compact ? 1 : 3"
            :space-between="24"
            :breakpoints="swiperOptions.breakpoints"
            @swiper="onSwiper"
            class="testimonial-slider"
        >
            <swiper-slide v-for="testimonial in testimonials" :key="testimonial.id">
                <div class="relative h-full p-8 pb-6 bg-white/92 backdrop-blur-xl rounded-2xl border border-white/90 shadow-xl shadow-slate-900/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-green-900/10">
                    <!-- Quote badge -->
                    <div class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center rounded-xl bg-gradient-to-br from-green-700 to-green-400 text-white text-lg opacity-90">
                        <i class="bi bi-quote"></i>
                    </div>

                    <!-- Star rating -->
                    <div class="flex items-center gap-0.5 mb-4">
                        <i
                            v-for="i in 5"
                            :key="i"
                            class="bi text-sm"
                            :class="i <= testimonial.rating ? 'bi-star-fill text-amber-400' : 'bi-star text-slate-200'"
                        ></i>
                        <span class="ml-2 text-xs font-bold text-slate-400">{{ testimonial.rating }}/5</span>
                    </div>

                    <!-- Testimonial text -->
                    <p class="text-sm text-slate-600 leading-relaxed mb-6 min-h-[80px]">
                        "{{ testimonial.description }}"
                    </p>

                    <!-- Author -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <img
                            :src="testimonial.image"
                            :alt="testimonial.name"
                            class="w-13 h-13 rounded-full object-cover border-3 border-green-100 shadow-lg shadow-green-900/15"
                        />
                        <div>
                            <h5 class="text-sm font-bold text-slate-900 mb-0.5">{{ testimonial.name }}</h5>
                            <p class="text-xs text-slate-400 m-0">{{ testimonial.designation }}</p>
                        </div>
                    </div>
                </div>
            </swiper-slide>
        </swiper>

        <!-- Navigation buttons -->
        <div v-if="testimonials.length > 3" class="flex justify-center gap-3 mt-8">
            <button @click="swiperPrevSlide"
                class="w-11 h-11 flex items-center justify-center rounded-full border border-slate-200 bg-white text-green-700 text-lg transition-all duration-200 shadow-md shadow-slate-900/5 hover:bg-gradient-to-br hover:from-green-700 hover:to-green-400 hover:text-white hover:border-transparent hover:scale-105"
                aria-label="Previous">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button @click="swiperNextSlide"
                class="w-11 h-11 flex items-center justify-center rounded-full border border-slate-200 bg-white text-green-700 text-lg transition-all duration-200 shadow-md shadow-slate-900/5 hover:bg-gradient-to-br hover:from-green-700 hover:to-green-400 hover:text-white hover:border-transparent hover:scale-105"
                aria-label="Next">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";

const props = defineProps({
    compact: { type: Boolean, default: false },
});

const swiperInstance = ref();

function onSwiper(swiper) {
    swiperInstance.value = swiper;
}

const swiperNextSlide = () => {
    swiperInstance.value.slideNext();
};

const swiperPrevSlide = () => {
    swiperInstance.value.slidePrev();
};

const swiperOptions = computed(() => ({
    breakpoints: props.compact
        ? {
              320: { slidesPerView: 1, spaceBetween: 16 },
              1200: { slidesPerView: 1, spaceBetween: 20 },
              1400: { slidesPerView: 2, spaceBetween: 24 },
          }
        : {
              320: { slidesPerView: 1, spaceBetween: 16 },
              768: { slidesPerView: 2, spaceBetween: 20 },
              1200: { slidesPerView: 3, spaceBetween: 24 },
          },
}));

const testimonials = ref([]);

onMounted(async () => {
    const response = await axios.get(`/testimonial/list`);
    testimonials.value = response.data.data?.testimonials;
});
</script>
