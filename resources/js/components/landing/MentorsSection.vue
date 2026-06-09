<template>
    <section class="mentors-section position-relative">
        <div class="mentors-decor mentors-decor--dots" aria-hidden="true"></div>
        <div class="mentors-decor mentors-decor--lines" aria-hidden="true"></div>

        <div class="container position-relative">
            <div class="mentors-header">
                <span class="mentors-label">{{ $t('Mentors') }}</span>
                <h2 class="mentors-title">
                    {{ $t("Learn from those who've been there, done that, and nailed it") }}
                </h2>
            </div>

            <div v-if="instructors.length" class="mentors-slider-wrap">
                <swiper
                    :modules="[Navigation]"
                    :space-between="20"
                    :breakpoints="breakpoints"
                    navigation
                    loop
                    class="mentors-slider"
                    :class="instructors.length < 5 ? 'mentors-slider--centered' : ''"
                >
                    <swiper-slide v-for="instructor in instructors" :key="instructor.id">
                        <article class="mentor-card">
                            <router-link
                                :to="'/instructor/' + instructor.id"
                                class="mentor-card__link text-decoration-none"
                            >
                                <img
                                    :src="instructor.profile_picture"
                                    :alt="instructor.name"
                                    class="mentor-card__photo"
                                    loading="lazy"
                                />
                                <div class="mentor-card__overlay">
                                    <div class="mentor-card__info">
                                        <h3 class="mentor-card__name">{{ instructor.name }}</h3>
                                        <p class="mentor-card__role">{{ mentorRole(instructor) }}</p>
                                    </div>
                                    <div class="mentor-card__footer">
                                        <span v-if="mentorCompany(instructor)" class="mentor-card__company">
                                            {{ mentorCompany(instructor) }}
                                        </span>
                                        <span class="mentor-card__linkedin">
                                            <i class="bi bi-linkedin" aria-hidden="true"></i>
                                            LinkedIn
                                        </span>
                                    </div>
                                </div>
                            </router-link>
                        </article>
                    </swiper-slide>
                </swiper>
            </div>

            <p v-else class="mentors-empty text-center mb-0">
                {{ $t('Featured mentors coming soon.') }}
            </p>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.mentors-section {
    padding: 4.5rem 0;
    background: #fff;
    overflow: hidden;
}

.mentors-decor {
    position: absolute;
    pointer-events: none;
    z-index: 0;

    &--dots {
        top: 2.5rem;
        right: 4%;
        width: 108px;
        height: 54px;
        background-image: radial-gradient(circle, #d1d5db 2px, transparent 2px);
        background-size: 18px 18px;
        opacity: 0.85;
    }

    &--lines {
        top: 28%;
        left: 0;
        width: 140px;
        height: 220px;
        background: repeating-linear-gradient(
            -55deg,
            transparent,
            transparent 10px,
            rgba(209, 213, 219, 0.35) 10px,
            rgba(209, 213, 219, 0.35) 11px
        );
        mask-image: linear-gradient(90deg, #000 30%, transparent 100%);
    }
}

.mentors-header {
    position: relative;
    z-index: 1;
    max-width: 640px;
    margin-bottom: 2.5rem;
}

.mentors-label {
    display: block;
    color: #f87171;
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.mentors-title {
    color: #111827;
    font-size: clamp(1.65rem, 3vw, 2.35rem);
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -0.02em;
    margin: 0;
}

.mentors-slider-wrap {
    position: relative;
    z-index: 1;
}

.mentors-slider {
    :deep(.swiper-button-next),
    :deep(.swiper-button-prev) {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #374151;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
        transition: all 0.25s ease;

        &::after {
            font-size: 0.95rem;
            font-weight: 700;
        }

        &:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
    }

    :deep(.swiper-button-prev) {
        left: -8px;
    }

    :deep(.swiper-button-next) {
        right: -8px;
    }
}

.mentors-slider--centered :deep(.swiper-wrapper) {
    justify-content: center;
}

.mentor-card {
    height: 100%;
}

.mentor-card__link {
    display: block;
    position: relative;
    height: 380px;
    border-radius: 22px;
    overflow: hidden;
    background: #111827;
    box-shadow: 0 8px 28px rgba(15, 23, 42, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;

    &:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.16);
    }
}

.mentor-card__photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
}

.mentor-card__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    background: linear-gradient(180deg, transparent 35%, rgba(0, 0, 0, 0.55) 68%, rgba(0, 0, 0, 0.92) 100%);
    padding: 1.1rem 1rem 1rem;
}

.mentor-card__info {
    margin-bottom: 0.85rem;
}

.mentor-card__name {
    color: #fff;
    font-size: 1.05rem;
    font-weight: 700;
    line-height: 1.3;
    margin: 0 0 0.25rem;
}

.mentor-card__role {
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.78rem;
    line-height: 1.45;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.mentor-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding-top: 0.75rem;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
}

.mentor-card__company {
    color: #fff;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.02em;
    text-transform: lowercase;
    opacity: 0.95;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.mentor-card__linkedin {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    flex-shrink: 0;
    padding: 0.28rem 0.55rem;
    border-radius: 6px;
    background: #fff;
    color: #0a66c2;
    font-size: 0.68rem;
    font-weight: 700;

    i {
        font-size: 0.85rem;
    }
}

.mentors-empty {
    color: #9ca3af;
    font-size: 0.95rem;
    padding: 2rem 0;
}

@media (max-width: 991px) {
    .mentors-decor--dots {
        right: 1rem;
        width: 72px;
        height: 36px;
        background-size: 12px 12px;
    }

    .mentors-decor--lines {
        width: 80px;
        height: 140px;
    }

    .mentor-card__link {
        height: 340px;
    }

    .mentors-slider :deep(.swiper-button-next),
    .mentors-slider :deep(.swiper-button-prev) {
        display: none;
    }
}

@media (max-width: 575px) {
    .mentors-section {
        padding: 3rem 0;
    }

    .mentor-card__link {
        height: 320px;
    }
}
</style>

<script setup>
import { ref, onMounted } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation } from "swiper/modules";

const instructors = ref([]);

const breakpoints = {
    320: { slidesPerView: 1.15, spaceBetween: 16 },
    576: { slidesPerView: 2, spaceBetween: 18 },
    992: { slidesPerView: 3, spaceBetween: 20 },
    1200: { slidesPerView: 4, spaceBetween: 20 },
    1400: { slidesPerView: 5, spaceBetween: 20 },
};

const mentorCompany = (instructor) => {
    const experience = instructor.experiences?.[0];
    if (experience?.company_name) {
        return experience.company_name;
    }

    const title = instructor.title || "";
    const atIndex = title.toLowerCase().lastIndexOf(" at ");
    if (atIndex > -1) {
        return title.slice(atIndex + 4).trim();
    }

    return "";
};

const mentorRole = (instructor) => {
    const experience = instructor.experiences?.[0];
    if (experience?.role && experience?.company_name) {
        return `${experience.role} at ${experience.company_name}`;
    }

    if (experience?.role) {
        return experience.role;
    }

    return instructor.title || "";
};

onMounted(async () => {
    try {
        const response = await axios.get("/instructor/list", {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                items_per_page: 15,
                page_number: 1,
                is_featured: true,
            },
        });
        instructors.value = response.data.data.instructors ?? [];
    } catch (error) {
        console.error("Error fetching mentors:", error);
    }
});
</script>
