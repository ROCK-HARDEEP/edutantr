<template>
    <section class="landing-stats">
        <PartnerCollegesSection />

        <div class="container landing-stats__container">
            <div v-if="showPlacements" class="placements-section">
                <div class="placements-header text-center mb-4 mb-lg-5">
                    <span class="placements-eyebrow">
                        <i class="bi bi-rocket-takeoff-fill me-1"></i>
                        {{ $t('Career Success') }}
                    </span>
                    <h3 class="placements-title fw-bold fs-1 mt-3 mb-2">
                        {{ $t('Placements') }} <span class="placements-title-accent">{{ $t('Achieved') }}</span>
                    </h3>
                    <p class="placements-subtitle mb-3">{{ $t('Success stories from our alumni') }}</p>
                    <p class="placements-motivation">
                        <i class="bi bi-lightning-charge-fill"></i>
                        {{ $t('Your dream career is closer than you think — join them!') }}
                    </p>
                </div>

                <HomeCardSlider
                    :items="placements"
                    :empty-text="$t('Placement highlights coming soon.')"
                    :breakpoints="placementBreakpoints"
                >
                    <template #default="{ item }">
                        <div class="placement-card h-100">
                            <div class="placement-card-accent" aria-hidden="true"></div>
                            <div class="placement-photo-hero">
                                <div class="placement-photo-ring" aria-hidden="true"></div>
                                <img
                                    :src="item.image"
                                    :alt="item.student_name"
                                    class="placement-photo"
                                    loading="lazy"
                                />
                                <div class="placement-photo-overlay" aria-hidden="true"></div>
                                <span class="placement-status placement-status--hero">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $t('Placed') }}
                                </span>
                                <span class="placement-trophy" aria-hidden="true">
                                    <i class="bi bi-trophy-fill"></i>
                                </span>
                            </div>
                            <div class="placement-card-content">
                                <h4 class="placement-name">{{ item.student_name }}</h4>
                                <div class="placement-company">
                                    <span class="placement-company-icon">
                                        <i class="bi bi-building-fill"></i>
                                    </span>
                                    <span>{{ item.company_name }}</span>
                                </div>
                                <p v-if="item.role" class="placement-role">
                                    <i class="bi bi-briefcase-fill"></i>
                                    {{ item.role }}
                                </p>
                                <div class="placement-footer">
                                    <i class="bi bi-patch-check-fill"></i>
                                    {{ $t('Successfully Placed') }}
                                </div>
                            </div>
                        </div>
                    </template>
                </HomeCardSlider>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.landing-stats {
    background: #f8fafc;
    padding: 0;
}

.landing-stats__container {
    padding-top: 3.5rem;
    padding-bottom: 3.5rem;
}

.placements-section {
    margin-bottom: 0;
}

.placements-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    background: linear-gradient(135deg, rgba(48, 108, 60, 0.1), rgba(34, 197, 94, 0.08));
    border: 1px solid rgba(48, 108, 60, 0.15);
    color: #15803d;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.placements-title {
    color: #0f172a;
}

.placements-title-accent {
    background: linear-gradient(90deg, #15803d, #22c55e, #4ade80);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.placements-subtitle {
    color: #64748b;
    font-size: 1.05rem;
    max-width: 540px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.placements-motivation {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 auto;
    padding: 0.5rem 1.15rem;
    border-radius: 50px;
    background: #ecfdf5;
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #166534;
    font-size: 0.88rem;
    font-weight: 600;
    max-width: 90%;
    line-height: 1.4;

    i {
        color: #22c55e;
        font-size: 1rem;
        flex-shrink: 0;
    }
}

.placements-section :deep(.swiper-button-next),
.placements-section :deep(.swiper-button-prev) {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #e2e8f0;
    color: #15803d;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);
    transition: all 0.25s ease;

    &::after {
        font-size: 0.95rem;
        font-weight: 700;
    }

    &:hover {
        background: #f0fdf4;
        border-color: rgba(34, 197, 94, 0.3);
    }
}

.placements-section :deep(.swiper-pagination-bullet) {
    background: #cbd5e1;
    opacity: 1;
}

.placements-section :deep(.swiper-pagination-bullet-active) {
    width: 22px;
    border-radius: 4px;
    background: #22c55e;
}

.placement-card {
    position: relative;
    overflow: hidden;
    background: #fff;
    border-radius: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 12px 36px rgba(15, 23, 42, 0.08);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;

    &:hover {
        transform: translateY(-10px);
        box-shadow: 0 24px 56px rgba(15, 23, 42, 0.14);
        border-color: rgba(34, 197, 94, 0.3);

        .placement-photo {
            transform: scale(1.04);
        }

        .placement-photo-ring {
            opacity: 1;
        }
    }
}

.placement-card-accent {
    height: 4px;
    background: linear-gradient(90deg, #15803d, #22c55e, #4ade80, #22c55e, #15803d);
    background-size: 200% 100%;
    animation: placement-accent-shimmer 4s linear infinite;
}

@keyframes placement-accent-shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

.placement-photo-hero {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: linear-gradient(180deg, #ecfdf5 0%, #f8fafc 100%);
}

.placement-photo-ring {
    position: absolute;
    inset: 12px;
    border-radius: 20px;
    border: 2px solid rgba(34, 197, 94, 0.35);
    opacity: 0.6;
    transition: opacity 0.35s ease;
    pointer-events: none;
    z-index: 2;
}

.placement-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    transition: transform 0.5s ease;
}

.placement-photo-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 45%, rgba(15, 23, 42, 0.55) 100%);
    pointer-events: none;
    z-index: 1;
}

.placement-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.placement-status--hero {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    z-index: 3;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
    color: #fff;
    background: rgba(21, 128, 61, 0.92);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(134, 239, 172, 0.4);
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.2);

    i {
        font-size: 0.85rem;
    }
}

.placement-trophy {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 3;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #fff;
    font-size: 1.1rem;
    border: 3px solid #fff;
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
}

.placement-card-content {
    padding: 1.35rem 1.35rem 1.25rem;
    text-align: center;
}

.placement-name {
    font-size: 1.15rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 0.65rem;
    line-height: 1.3;
    letter-spacing: -0.01em;
}

.placement-company {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.55rem;
    padding: 0.45rem 0.85rem;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}

.placement-company-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #15803d;
    font-size: 0.85rem;
    flex-shrink: 0;
}

.placement-role {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: #64748b;
    margin: 0 0 1rem;
    line-height: 1.4;

    i {
        color: #22c55e;
        font-size: 0.8rem;
        flex-shrink: 0;
    }
}

.placement-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding-top: 0.9rem;
    border-top: 1px dashed #e2e8f0;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #15803d;

    i {
        color: #22c55e;
        font-size: 0.9rem;
    }
}

@media (max-width: 575px) {
    .placements-title {
        font-size: 1.75rem !important;
    }

    .placement-photo-hero {
        height: 240px;
    }

    .placements-motivation {
        font-size: 0.82rem;
        padding: 0.5rem 1rem;
    }
}
</style>

<script setup>
import { ref, onMounted } from "vue";
import HomeCardSlider from "./HomeCardSlider.vue";
import PartnerCollegesSection from "./PartnerCollegesSection.vue";

const placements = ref([]);
const showPlacements = false;

const placementBreakpoints = {
    320: { slidesPerView: 1, spaceBetween: 16 },
    576: { slidesPerView: 1, spaceBetween: 20 },
    768: { slidesPerView: 2, spaceBetween: 24 },
    1200: { slidesPerView: 3, spaceBetween: 28 },
};

onMounted(async () => {
    if (!showPlacements) {
        return;
    }

    try {
        const placementsRes = await axios.get("/home/placements");
        placements.value = placementsRes.data.data.placements ?? [];
    } catch (error) {
        console.error("Error fetching landing statistics:", error);
    }
});
</script>
