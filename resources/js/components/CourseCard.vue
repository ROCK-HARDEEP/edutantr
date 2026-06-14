<template>
    <div class="course-card h-100" :class="{ 'course-card--popular': variant === 'popular' }">
        <div v-if="variant === 'popular'" class="popular-course-card h-100 d-flex flex-column">
            <router-link :to="'/details/' + course.id" class="popular-course-card__thumb">
                <img :src="course.thumbnail" :alt="course.title" />
            </router-link>

            <div class="popular-course-card__body flex-grow-1">
                <div class="popular-course-card__meta">
                    <router-link
                        :to="'/instructor/' + course.instructor.id"
                        class="popular-course-card__instructor text-decoration-none"
                    >
                        <img
                            :src="course.instructor.profile_picture"
                            alt=""
                            width="32"
                            height="32"
                            class="rounded-circle object-fit-cover"
                        />
                        <span>{{ shortName(course.instructor?.name) }}</span>
                    </router-link>
                    <span class="popular-course-card__category">{{ course.category }}</span>
                </div>

                <router-link :to="`/details/${course.id}`" class="popular-course-card__title text-decoration-none">
                    {{ shortText(course.title) }}
                </router-link>

                <div class="popular-course-card__stats">
                    <span>
                        <i class="bi bi-play-circle" aria-hidden="true"></i>
                        {{ course.chapter_count }} {{ $t('Lessons') }}
                    </span>
                    <span>
                        <i class="bi bi-clock" aria-hidden="true"></i>
                        {{ formatPopularDuration(course?.total_duration) }}
                    </span>
                </div>
            </div>

            <div class="popular-course-card__footer popular-course-card__footer--rating-only">
                <div class="popular-course-card__rating">
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                    <strong>{{ course.average_rating }}</strong>
                    ({{ course.review_count }})
                </div>
            </div>
        </div>

        <div v-else class="card border-light theme-shadow overflow-hidden h-100 premium-course-card">
            <router-link :to="'/details/' + course.id" class="course-thumbnail-wrapper position-relative">
                <img :src="course.thumbnail" class="course-thumbnail card-img-top object-fit-cover" alt="..." />
                <div class="category-badge">
                    <strong>{{ course.category }}</strong>
                </div>
            </router-link>
            <div class="card-body pb-0">
                <div class="course-details-wrapper">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-mortarboard"></i>
                        <span>{{ course.chapter_count }} {{ $t("Classes") }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock text-warning"></i>
                        <span>{{ formatDuration(course?.total_duration) }}</span>
                    </div>
                </div>

                <div class="header-metadata">
                    <router-link :to="`/details/${course.id}`" class="text-decoration-none d-block mb-2">
                        <p class="course-title fw-bold text-hover">
                            {{ shortText(course.title) }}
                        </p>
                    </router-link>
                </div>
                <div
                    class="card-text text-muted d-flex flex-column flex-xl-row gap-2 justify-content-between mb-3 mt-3 mt-md-0">
                    <div v-if="!course?.is_free && !course?.is_enrolled" class="d-flex align-items-center">
                        <strong class="text-primary me-2">
                            <span v-if="masterStore?.masterData?.currency_position == 'Left'" class="fs-4">
                                {{ masterStore?.masterData?.currency_symbol }}{{ course.price ?? course.regular_price }}
                            </span>
                            <span v-else class="fs-4">
                                {{ course.price ?? course.regular_price }}{{ masterStore?.masterData?.currency_symbol }}
                            </span>
                        </strong>
                        <span v-if="course?.price" class="text-muted text-decoration-line-through">
                            <span v-if="masterStore?.masterData?.currency_position == 'Left'" style="font-size: 14px;">
                                {{ masterStore?.masterData?.currency_symbol }}{{ course.regular_price }}
                            </span>
                            <span v-else style="font-size: 14px;">
                                {{ course.regular_price }}{{ masterStore?.masterData?.currency_symbol }}
                            </span>
                        </span>
                    </div>
                    <div v-else class="d-flex w-100 align-self-center me-auto my-auto mt-1">
                        <span class="badge px-3 py-2 rounded fw-semibold"
                            :class="course?.is_enrolled ? 'bg-primary text-white' : 'bg-light text-primary border border-primary'"
                            style="font-size: 13px;">
                            {{ course?.is_enrolled ? $t("Enrolled") : $t("Free") }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-light py-0">
                <div class="row">
                    <div class="col-12 text-muted course-metadata py-2">
                        <router-link :to="'/instructor/' + course.instructor.id"
                            class="d-flex align-items-center gap-2 text-decoration-none text-muted">
                            <img :src="course.instructor.profile_picture" alt="instructor-avatar" width="35" height="35"
                                class="rounded-circle object-fit-cover">
                            <span class="fw-bold">{{ shortName(course.instructor?.name) }}</span>
                        </router-link>
                        <span class="order-md-1 order-xl-2">
                            <i class="bi bi-star-fill me-2 text-warning"></i>
                            <strong>{{ course.average_rating }}</strong>
                            ({{ course.review_count }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.course-card--popular {
    .popular-course-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: border-color 0.3s ease;

        &:hover {
            border-color: #fed7aa;
        }
    }

    .popular-course-card__thumb {
        display: block;
        height: 220px;
        overflow: hidden;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
    }

    &:hover .popular-course-card__thumb img {
        transform: scale(1.06);
    }

    .popular-course-card__body {
        padding: 1.25rem 1.25rem 1rem;
    }

    .popular-course-card__meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.65rem;
    }

    .popular-course-card__instructor {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
        min-width: 0;

        span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    .popular-course-card__category {
        flex-shrink: 0;
        padding: 0.25rem 0.65rem;
        border-radius: 50px;
        background: #fff7ed;
        color: #ea580c;
        font-size: 0.78rem;
        font-weight: 600;
        max-width: 45%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .popular-course-card__title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #111827;
        font-size: 1.05rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        min-height: 2.95rem;
    }

    .popular-course-card__stats {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6b7280;

        span {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        i {
            color: #9ca3af;
            font-size: 0.85rem;
        }
    }

    .popular-course-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: #f9fafb;
        border-top: 1px solid #f3f4f6;
        margin-top: auto;

        &--rating-only {
            justify-content: center;
        }
    }

    .popular-course-card__rating {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.9rem;
        color: #6b7280;

        i {
            color: #fbbf24;
            font-size: 0.85rem;
        }

        strong {
            color: #374151;
        }
    }
}

.header-metadata {
    height: 50px;
    overflow: hidden;
    margin-bottom: 5px;
}

.course-metadata {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    color: #64748B !important;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 20px;
}

.course-title {
    overflow: hidden;
    color: #0F172A;
    font-family: Lexend;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: 24px;
}

.goto-details-icon {
    background-color: #eee;
}

.course-card:not(.course-card--popular) {
    transition: all 0.35s ease;

    .premium-course-card {
        border-radius: 18px;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
    }

    .course-thumbnail-wrapper {
        height: 200px;
        overflow: hidden;

        .course-thumbnail {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: transform 0.4s ease;
        }
    }

    .border-light {
        border-color: #e2e8f0 !important;
    }

    &:hover {
        .premium-course-card {
            border-color: rgba(48, 108, 60, 0.2) !important;
            box-shadow: 0 16px 40px rgba(48, 108, 60, 0.12);
        }

        .course-thumbnail {
            transform: scale(1.08);
        }
    }
}

.category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #15803d, #22c55e);
    color: #fff;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 4px 12px rgba(48, 108, 60, 0.3);
}

.course-details-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    font-size: 14px;
    font-weight: 600;
    color: var(--bg-primary);
    margin-bottom: 10px;
}

@media (max-width: 576px) {
    .card-body {
        padding: 0.5rem 0.5rem;
    }

    .card-footer {
        padding: 0.5rem 0.5rem;
    }

    .header-metadata {
        height: 75px;
    }

    .course-metadata {
        border-right: none;
        border-bottom: 1px solid #eaeaea;
        border-top: 1px solid #eaeaea;
    }
}
</style>

<script setup>
import { useMasterStore } from "@/stores/master";

const masterStore = useMasterStore();

defineProps({
    course: Object,
    variant: {
        type: String,
        default: "default",
    },
});

function shortText(text) {
    const width = window.innerWidth;
    const maxLength = width <= 576 ? 20 : 60;
    return text.length > maxLength ? text.slice(0, maxLength) + "..." : text;
}

const shortName = (name) => {
    if (!name) return '';
    const names = name.split(' ');
    if (names.length === 1) return names[0];
    return names[0] + ' ' + names[names.length - 1];
};

const formatDuration = (duration) => {
    if (duration >= 60) {
        const hours = Math.floor(duration / 60);
        const minutes = duration % 60;
        return `${hours} hour${hours > 1 ? "s" : ""}${minutes > 0 ? ` ${minutes} min` : ""}`;
    }
    return `${duration} min`;
};

const formatPopularDuration = (duration) => {
    const total = Number(duration) || 0;
    const hours = Math.floor(total / 60);
    const minutes = total % 60;
    return `${String(hours).padStart(2, "0")} HRS ${String(minutes).padStart(2, "0")} Mins`;
};
</script>
