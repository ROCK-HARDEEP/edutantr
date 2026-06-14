<template>
    <section class="our-process">
        <div class="our-process__bg" aria-hidden="true"></div>
        <div class="our-process__glow our-process__glow--left" aria-hidden="true"></div>
        <div class="our-process__glow our-process__glow--right" aria-hidden="true"></div>
        <div class="our-process__particles" aria-hidden="true">
            <span
                v-for="n in 8"
                :key="`particle-${n}`"
                class="our-process__particle"
                :style="{ '--particle-i': n }"
            ></span>
        </div>

        <div class="container position-relative">
            <SectionHeader
                class="our-process__header"
                :eyebrow="$t('How It Works')"
                icon="bi bi-signpost-split-fill"
                :subtitle="$t('A simple step-by-step journey from enrollment to career success.')"
            >
                <template #title>
                    {{ $t('Our') }}
                    <span class="accent">{{ $t('Process') }}</span>
                </template>
            </SectionHeader>

            <div class="our-process__timeline">
                <div class="our-process__track" aria-hidden="true">
                    <span class="our-process__track-shimmer"></span>
                    <span class="our-process__track-runner"></span>
                </div>

                <article
                    v-for="(step, index) in steps"
                    :key="step.title"
                    class="process-step"
                    :style="{ '--step-delay': `${index * 0.14}s` }"
                >
                    <div class="process-step__top">
                        <span class="process-step__number">{{ String(index + 1).padStart(2, '0') }}</span>
                        <div class="process-step__node" aria-hidden="true">
                            <span class="process-step__ring"></span>
                            <span class="process-step__icon">
                                <i :class="step.icon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="process-step__card">
                        <span class="process-step__label">{{ step.label }}</span>
                        <h3 class="process-step__title">{{ step.title }}</h3>
                        <p class="process-step__desc">{{ step.description }}</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.our-process {
    position: relative;
    padding: 3rem 0;
    overflow: hidden;
    background: linear-gradient(180deg, #ecfdf5 0%, #f8fafc 55%, #fff 100%);
}

.our-process__header {
    margin-bottom: 2rem;

    :deep(.section-title) {
        font-size: clamp(1.35rem, 2.5vw, 1.85rem);
        margin-bottom: 0.4rem;
    }

    :deep(.section-subtitle) {
        font-size: 0.92rem;
        max-width: 520px;
    }
}

.our-process__bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 45% at 10% 20%, rgba(34, 197, 94, 0.12) 0%, transparent 60%),
        radial-gradient(ellipse 55% 40% at 90% 75%, rgba(21, 128, 61, 0.1) 0%, transparent 58%);
    pointer-events: none;
    animation: process-bg-shift 14s ease-in-out infinite alternate;
}

.our-process__glow {
    position: absolute;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    opacity: 0.55;
}

.our-process__glow--left {
    top: 15%;
    left: -8%;
    background: rgba(74, 222, 128, 0.25);
    animation: process-glow-float-left 9s ease-in-out infinite;
}

.our-process__glow--right {
    bottom: 10%;
    right: -6%;
    background: rgba(34, 197, 94, 0.2);
    animation: process-glow-float-right 11s ease-in-out infinite;
}

.our-process__particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.our-process__particle {
    position: absolute;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(34, 197, 94, 0.45);
    box-shadow: 0 0 12px rgba(34, 197, 94, 0.35);
    opacity: 0;
    animation: process-particle-rise 7s linear infinite;
    animation-delay: calc(var(--particle-i) * -0.9s);
    left: calc(8% + (var(--particle-i) - 1) * 11%);
    bottom: -10px;
}

/* ─── Desktop: horizontal process flow ─── */
.our-process__timeline {
    position: relative;
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1rem;
    padding-top: 1.5rem;
}

.our-process__track {
    position: absolute;
    top: 2.65rem;
    left: 8%;
    right: 8%;
    height: 3px;
    border-radius: 3px;
    background: linear-gradient(90deg, rgba(34, 197, 94, 0.2), #22c55e, #15803d, #22c55e, rgba(34, 197, 94, 0.2));
    box-shadow: 0 0 16px rgba(34, 197, 94, 0.2);
    z-index: 0;
    overflow: hidden;
}

.our-process__track-shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255, 255, 255, 0.55) 45%,
        rgba(187, 247, 208, 0.9) 50%,
        rgba(255, 255, 255, 0.55) 55%,
        transparent 100%
    );
    background-size: 220% 100%;
    animation: process-track-shimmer 3.2s linear infinite;
}

.our-process__track-runner {
    position: absolute;
    top: 50%;
    left: 0;
    width: 14px;
    height: 14px;
    margin-top: -7px;
    border-radius: 50%;
    background: radial-gradient(circle, #fff 0%, #4ade80 45%, #15803d 100%);
    box-shadow: 0 0 14px rgba(34, 197, 94, 0.75), 0 0 28px rgba(34, 197, 94, 0.35);
    animation: process-track-runner 5.5s linear infinite;
}

.process-step {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    animation: process-step-in 0.75s ease backwards;
    animation-delay: var(--step-delay, 0s);
}

.process-step__top {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.process-step__number {
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    color: #15803d;
    background: #ecfdf5;
    padding: 0.2rem 0.55rem;
    border-radius: 50px;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.process-step__node {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.process-step__ring {
    position: absolute;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 2px solid rgba(34, 197, 94, 0.45);
    animation: process-node-ring 2.8s ease-out infinite;
}

.process-step__icon {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #22c55e, #15803d);
    color: #fff;
    font-size: 1.15rem;
    border: 3px solid #fff;
    box-shadow: 0 6px 20px rgba(21, 128, 61, 0.28);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: process-icon-bob 4s ease-in-out infinite;
    animation-delay: var(--step-delay, 0s);
}

.process-step:hover .process-step__icon {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 28px rgba(21, 128, 61, 0.38);
}

.process-step__card {
    width: 100%;
    padding: 1rem 0.85rem;
    background: #fff;
    border-radius: 16px;
    border: 1px solid rgba(34, 197, 94, 0.14);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    animation: process-card-glow 4.5s ease-in-out infinite;
    animation-delay: calc(var(--step-delay, 0s) + 0.3s);
}

.process-step:hover .process-step__card {
    transform: translateY(-3px);
    border-color: rgba(34, 197, 94, 0.3);
    box-shadow: 0 14px 32px rgba(21, 128, 61, 0.1);
}

.process-step__label {
    display: inline-block;
    font-size: 0.65rem;
    font-weight: 700;
    color: #15803d;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 0.45rem;
    padding: 0.2rem 0.55rem;
    border-radius: 50px;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(21, 128, 61, 0.06));
    border: 1px solid rgba(34, 197, 94, 0.15);
}

.process-step__title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.5rem;
    line-height: 1.35;
}

.process-step__desc {
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.55;
    margin: 0;
}

/* ─── Tablet: 3 columns, 2 rows ─── */
@media (max-width: 1199px) {
    .our-process__timeline {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.25rem 1rem;
        padding-top: 0;
    }

    .our-process__track {
        display: none;
    }

    .process-step__top {
        margin-bottom: 0.85rem;
    }
}

/* ─── Mobile: vertical timeline ─── */
@media (max-width: 767px) {
    .our-process {
        padding: 2rem 0;
    }

    .our-process__header {
        margin-bottom: 1.5rem;
    }

    .our-process__timeline {
        display: flex;
        flex-direction: column;
        gap: 0;
        padding-left: 0.5rem;
    }

    .our-process__track {
        display: block;
        top: 0;
        bottom: 0;
        left: 1.65rem;
        right: auto;
        width: 3px;
        height: auto;
        background: linear-gradient(
            180deg,
            rgba(34, 197, 94, 0.15) 0%,
            #22c55e 20%,
            #15803d 50%,
            #22c55e 80%,
            rgba(34, 197, 94, 0.15) 100%
        );
    }

    .our-process__track-shimmer {
        background: linear-gradient(
            180deg,
            transparent 0%,
            rgba(255, 255, 255, 0.55) 45%,
            rgba(187, 247, 208, 0.9) 50%,
            rgba(255, 255, 255, 0.55) 55%,
            transparent 100%
        );
        background-size: 100% 220%;
        animation: process-track-shimmer-vertical 3.2s linear infinite;
    }

    .our-process__track-runner {
        top: 0;
        left: 50%;
        margin-top: 0;
        margin-left: -7px;
        animation: process-track-runner-vertical 6s linear infinite;
    }

    .our-process__particles {
        display: none;
    }

    .process-step {
        flex-direction: row;
        align-items: flex-start;
        gap: 1rem;
        text-align: left;
        padding: 0.85rem 0;
    }

    .process-step__top {
        flex-shrink: 0;
        margin-bottom: 0;
        gap: 0.35rem;
    }

    .process-step__number {
        display: none;
    }

    .process-step__icon {
        width: 44px;
        height: 44px;
        font-size: 1rem;
        border-width: 2px;
    }

    .process-step__card {
        flex: 1;
        padding: 1rem 1.1rem;
        border-radius: 14px;
    }

    .process-step__title {
        font-size: 1rem;
    }

    .process-step__desc {
        font-size: 0.85rem;
        line-height: 1.6;
    }
}

@keyframes process-bg-shift {
    0% {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    100% {
        transform: scale(1.04) translateY(-1.5%);
        opacity: 0.92;
    }
}

@keyframes process-glow-float-left {
    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(24px, -18px) scale(1.08);
    }
}

@keyframes process-glow-float-right {
    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(-20px, 16px) scale(1.06);
    }
}

@keyframes process-particle-rise {
    0% {
        transform: translateY(0) scale(0.6);
        opacity: 0;
    }
    12% {
        opacity: 0.75;
    }
    80% {
        opacity: 0.35;
    }
    100% {
        transform: translateY(-220px) scale(1.1);
        opacity: 0;
    }
}

@keyframes process-track-shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

@keyframes process-track-shimmer-vertical {
    0% {
        background-position: 0 200%;
    }
    100% {
        background-position: 0 -200%;
    }
}

@keyframes process-track-runner {
    0% {
        left: 0;
        opacity: 0.4;
    }
    8% {
        opacity: 1;
    }
    92% {
        opacity: 1;
    }
    100% {
        left: calc(100% - 14px);
        opacity: 0.4;
    }
}

@keyframes process-track-runner-vertical {
    0% {
        top: 0;
        opacity: 0.4;
    }
    8% {
        opacity: 1;
    }
    92% {
        opacity: 1;
    }
    100% {
        top: calc(100% - 14px);
        opacity: 0.4;
    }
}

@keyframes process-step-in {
    0% {
        opacity: 0;
        transform: translateY(22px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes process-node-ring {
    0% {
        transform: scale(1);
        opacity: 0.75;
    }
    70% {
        transform: scale(1.55);
        opacity: 0;
    }
    100% {
        transform: scale(1.55);
        opacity: 0;
    }
}

@keyframes process-icon-bob {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-4px);
    }
}

@keyframes process-card-glow {
    0%,
    100% {
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        border-color: rgba(34, 197, 94, 0.14);
    }
    50% {
        box-shadow: 0 12px 30px rgba(21, 128, 61, 0.12);
        border-color: rgba(34, 197, 94, 0.28);
    }
}
</style>

<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";
import SectionHeader from "./SectionHeader.vue";

const { t } = useI18n();

const steps = computed(() => [
    {
        label: t("Step 01"),
        title: t("Join or Purchase Course"),
        description: t("Browse our catalog, pick the right course for your goals, and enroll in just a few clicks."),
        icon: "bi bi-cart-check",
    },
    {
        label: t("Step 02"),
        title: t("Learn from Our Experts"),
        description: t("Follow structured lessons taught by industry professionals with real-world experience."),
        icon: "bi bi-person-video3",
    },
    {
        label: t("Step 03"),
        title: t("Do Project"),
        description: t("Apply what you learn by building hands-on projects that strengthen your practical skills."),
        icon: "bi bi-folder2-open",
    },
    {
        label: t("Step 04"),
        title: t("Get Certified"),
        description: t("Complete the course and earn a shareable certificate to showcase your achievement."),
        icon: "bi bi-award",
    },
    {
        label: t("Step 05"),
        title: t("Get Job Ready Skills"),
        description: t("Gain in-demand skills and portfolio work that prepare you for interviews and the workplace."),
        icon: "bi bi-briefcase",
    },
]);
</script>
