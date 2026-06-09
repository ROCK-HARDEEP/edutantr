<template>
    <section class="why-choose">
        <div class="why-choose__bg" aria-hidden="true"></div>
        <div class="why-choose__overlay" aria-hidden="true"></div>

        <div class="container position-relative">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <span class="why-badge">
                        <i class="bi bi-building"></i>
                        {{ $t('Why Choose Us') }}
                    </span>

                    <h2 class="why-heading">
                        {{ $t('Learn & Grow Your Skills') }}
                        <span class="why-heading-accent">{{ $t('From Anywhere') }}</span>
                    </h2>

                    <div class="why-card">
                        <h3 class="why-card-title">
                            {{ $t('Why Choose {name}?', { name: masterStore?.masterData?.name ?? 'LMS' }) }}
                        </h3>

                        <ul class="why-features">
                            <li v-for="feature in features" :key="feature.title" class="why-feature">
                                <span class="why-feature-check" aria-hidden="true">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                                <div>
                                    <h4 class="why-feature-title">{{ feature.title }}</h4>
                                    <p class="why-feature-desc">{{ feature.description }}</p>
                                </div>
                            </li>
                        </ul>

                        <router-link to="/courses" class="why-cta">
                            <span>{{ $t('Get Started') }}</span>
                            <span class="why-cta-icon" aria-hidden="true">
                                <i class="bi bi-arrow-right"></i>
                            </span>
                        </router-link>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="why-visual">
                        <div class="why-visual-frame">
                            <img
                                :src="masterStore?.masterData?.about_thumbnail ?? masterStore?.masterData?.hero_thumbnail ?? '/assets/website/banner-hero.png'"
                                :alt="$t('Student learning')"
                                class="why-visual-img"
                                loading="lazy"
                            />
                        </div>

                        <div class="why-seal" aria-hidden="true">
                            <div class="why-seal-inner">
                                <i class="bi bi-journal-bookmark-fill why-seal-icon"></i>
                                <p class="why-seal-text">
                                    {{ $t('Best E-Learning Management Platforms') }}
                                </p>
                            </div>
                        </div>

                        <div class="why-stats-bar">
                            <div class="why-stat">
                                <span class="why-stat-icon">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </span>
                                <div>
                                    <strong>{{ masterStore?.masterData?.total_instructors ?? '20' }}+</strong>
                                    <span>{{ $t('Skilled Instructors') }}</span>
                                </div>
                            </div>
                            <div class="why-stat-divider" aria-hidden="true"></div>
                            <div class="why-stat">
                                <span class="why-stat-icon">
                                    <i class="bi bi-people-fill"></i>
                                </span>
                                <div>
                                    <strong>{{ masterStore?.masterData?.total_enrollments ?? '1900' }}+</strong>
                                    <span>{{ $t('Happy Students') }}</span>
                                </div>
                            </div>
                            <div class="why-stat-divider" aria-hidden="true"></div>
                            <div class="why-stat">
                                <span class="why-stat-icon">
                                    <i class="bi bi-play-circle-fill"></i>
                                </span>
                                <div>
                                    <strong>{{ masterStore?.masterData?.total_courses ?? '500' }}+</strong>
                                    <span>{{ $t('Video Courses') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.why-choose {
    position: relative;
    padding: 5rem 4.5rem;
    overflow: hidden;
}

.why-choose__bg {
    position: absolute;
    inset: 0;
    background: #f3f4f6 url("/assets/website/why-choose-us/why-choose-us-bg.png") no-repeat center;
    background-size: cover;
}

.why-choose__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.92) 0%,
        rgba(248, 250, 252, 0.88) 45%,
        rgba(255, 255, 255, 0.8) 100%
    );
}

.why-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.45rem 1rem;
    margin-bottom: 1.25rem;
    border-radius: 50px;
    background: #fff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
    color: #374151;
    font-size: 0.82rem;
    font-weight: 600;

    i {
        color: #f97316;
        font-size: 0.9rem;
    }
}

.why-heading {
    font-size: clamp(1.85rem, 3.5vw, 2.65rem);
    font-weight: 800;
    color: #111827;
    line-height: 1.2;
    letter-spacing: -0.02em;
    margin-bottom: 1.75rem;
    max-width: 520px;
}

.why-heading-accent {
    display: block;
    color: #111827;
}

.why-card {
    background: #fff;
    border-radius: 24px;
    padding: 2rem 2rem 2.25rem;
    border: 1px solid rgba(229, 231, 235, 0.9);
    box-shadow:
        0 20px 50px rgba(15, 23, 42, 0.08),
        0 4px 12px rgba(15, 23, 42, 0.04);
}

.why-card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1.5rem;
}

.why-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.75rem;
    display: flex;
    flex-direction: column;
    gap: 1.35rem;
}

.why-feature {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.why-feature-check {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, #fb923c, #f97316);
    color: #fff;
    font-size: 0.95rem;
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
}

.why-feature-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.2rem;
}

.why-feature-desc {
    font-size: 0.85rem;
    color: #6b7280;
    margin: 0;
    line-height: 1.55;
}

.why-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.7rem 0.7rem 0.7rem 1.6rem;
    border-radius: 50px;
    background: linear-gradient(135deg, #fb923c, #f97316);
    color: #fff;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    box-shadow: 0 10px 28px rgba(249, 115, 22, 0.35);
    transition: transform 0.25s ease, box-shadow 0.25s ease;

    &:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 36px rgba(249, 115, 22, 0.45);
    }
}

.why-cta-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.22);
    font-size: 1rem;
}

.why-visual {
    position: relative;
    padding: 1rem 0 4.5rem;
}

.why-visual-frame {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 28px 60px rgba(15, 23, 42, 0.14);
    background: #fff;
    padding: 0.5rem;
}

.why-visual-img {
    width: 100%;
    display: block;
    border-radius: 22px;
    object-fit: cover;
    max-height: 520px;
    min-height: 380px;
}

.why-seal {
    position: absolute;
    top: 12%;
    left: -4%;
    z-index: 2;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
    border: 4px solid #f9fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: seal-float 5s ease-in-out infinite;
}

.why-seal-inner {
    text-align: center;
    padding: 0.5rem;
}

.why-seal-icon {
    display: block;
    font-size: 1.5rem;
    color: #f97316;
    margin-bottom: 0.35rem;
}

.why-seal-text {
    font-size: 0.58rem;
    font-weight: 700;
    color: #374151;
    line-height: 1.35;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

@keyframes seal-float {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-8px);
    }
}

.why-stats-bar {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    display: flex;
    align-items: center;
    gap: 0;
    width: calc(100% - 1rem);
    max-width: 480px;
    padding: 1.1rem 1.25rem;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.1);
}

.why-stat {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    min-width: 0;

    strong {
        display: block;
        font-size: 1rem;
        font-weight: 800;
        color: #111827;
        line-height: 1.2;
    }

    span {
        display: block;
        font-size: 0.68rem;
        color: #6b7280;
        font-weight: 500;
        line-height: 1.3;
    }
}

.why-stat-icon {
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #fff7ed;
    color: #f97316;
    font-size: 1.1rem;
}

.why-stat-divider {
    width: 1px;
    height: 36px;
    background: #e5e7eb;
    flex-shrink: 0;
    margin: 0 0.35rem;
}

@media (max-width: 991px) {
    .why-choose {
        padding: 3.5rem 1rem;
    }

    .why-heading {
        max-width: none;
    }

    .why-card {
        padding: 1.5rem;
    }

    .why-seal {
        left: 2%;
        width: 110px;
        height: 110px;
    }

    .why-visual {
        padding-bottom: 5rem;
    }
}

@media (max-width: 575px) {
    .why-stats-bar {
        flex-direction: column;
        gap: 0.85rem;
        padding: 1rem;
        position: relative;
        left: auto;
        transform: none;
        margin-top: -2rem;
        width: 100%;
    }

    .why-stat-divider {
        width: 100%;
        height: 1px;
        margin: 0;
    }

    .why-visual {
        padding-bottom: 0;
    }

    .why-seal {
        width: 96px;
        height: 96px;
        top: 8%;
        left: 4%;
    }

    .why-seal-text {
        font-size: 0.5rem;
    }
}
</style>

<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";
import { useMasterStore } from "@/stores/master";

const { t } = useI18n();
const masterStore = useMasterStore();

const features = computed(() => [
    {
        title: t("Expert Instructors"),
        description: t("Learn from certified professionals with years of experience"),
    },
    {
        title: t("Certificate of Completion"),
        description: t("Earn shareable certificates to boost your career or resume"),
    },
    {
        title: t("High-Quality Content"),
        description: t("All courses are reviewed for quality and updated regularly"),
    },
]);
</script>
