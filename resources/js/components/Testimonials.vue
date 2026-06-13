<template>
    <div class="testimonials-wrap position-relative" :class="{ 'testimonials-wrap--compact': compact }">
        <swiper
            :slides-per-view="compact ? 1 : 3"
            :space-between="24"
            :breakpoints="swiperOptions.breakpoints"
            @swiper="onSwiper"
            class="testimonial-slider"
        >
            <swiper-slide v-for="testimonial in testimonials" :key="testimonial.id">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i
                            v-for="i in 5"
                            :key="i"
                            :class="i <= testimonial.rating ? 'bi bi-star-fill' : 'bi bi-star'"
                        ></i>
                        <span class="rating-num">{{ testimonial.rating }}/5</span>
                    </div>
                    <p class="testimonial-text">"{{ testimonial.description }}"</p>
                    <div class="testimonial-author">
                        <img :src="testimonial.image" :alt="testimonial.name" class="author-avatar" />
                        <div>
                            <h5 class="author-name">{{ testimonial.name }}</h5>
                            <p class="author-role">{{ testimonial.designation }}</p>
                        </div>
                    </div>
                    <div class="quote-badge" aria-hidden="true">
                        <i class="bi bi-quote"></i>
                    </div>
                </div>
            </swiper-slide>
        </swiper>

        <div v-if="testimonials.length > 3" class="testimonial-nav">
            <button @click="swiperPrevSlide" class="nav-btn" aria-label="Previous">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button @click="swiperNextSlide" class="nav-btn" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</template>

<style scoped lang="scss">
.testimonials-wrap {
    padding: 0 0.5rem;
}

.testimonials-wrap--compact {
    padding: 0;
    overflow: hidden;
    max-width: 100%;
}

.testimonials-wrap--compact :deep(.swiper) {
    overflow: hidden;
    max-width: 100%;
}

.testimonial-card {
    position: relative;
    height: 100%;
    padding: 2rem 1.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;

    &:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(48, 108, 60, 0.12);
    }
}

.testimonial-stars {
    display: flex;
    align-items: center;
    gap: 0.15rem;
    margin-bottom: 1rem;

    i {
        font-size: 0.85rem;
        color: #fbbf24;
    }

    .bi-star {
        color: #e2e8f0;
    }

    .rating-num {
        margin-left: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: #64748b;
    }
}

.testimonial-text {
    font-size: 0.95rem;
    color: #334155;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    min-height: 80px;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding-top: 1rem;
    border-top: 1px solid #f1f5f9;
}

.author-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #dcfce7;
    box-shadow: 0 4px 12px rgba(48, 108, 60, 0.15);
}

.author-name {
    font-size: 0.92rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.15rem;
}

.author-role {
    font-size: 0.78rem;
    color: #64748b;
    margin: 0;
}

.quote-badge {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #15803d, #22c55e);
    color: #fff;
    font-size: 1.1rem;
    opacity: 0.9;
}

.testimonial-nav {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 2rem;
}

.nav-btn {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #15803d;
    font-size: 1.1rem;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);

    &:hover {
        background: linear-gradient(135deg, #15803d, #22c55e);
        color: #fff;
        border-color: transparent;
        transform: scale(1.05);
    }
}
</style>

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
