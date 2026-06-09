<template>
    <section class="home-marquee" aria-label="Announcements">
        <div class="home-marquee__label">
            <i class="bi bi-megaphone-fill" aria-hidden="true"></i>
            <span>{{ $t('Latest Updates') }}</span>
        </div>

        <div class="home-marquee__track-wrap">
            <div class="home-marquee__track" :style="{ '--marquee-duration': `${duration}s` }">
                <div class="home-marquee__content">
                    <span
                        v-for="(item, index) in items"
                        :key="`a-${index}`"
                        class="home-marquee__item"
                    >
                        <i :class="item.icon" aria-hidden="true"></i>
                        {{ item.text }}
                        <span class="home-marquee__dot" aria-hidden="true">•</span>
                    </span>
                </div>
                <div class="home-marquee__content" aria-hidden="true">
                    <span
                        v-for="(item, index) in items"
                        :key="`b-${index}`"
                        class="home-marquee__item"
                    >
                        <i :class="item.icon" aria-hidden="true"></i>
                        {{ item.text }}
                        <span class="home-marquee__dot" aria-hidden="true">•</span>
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from "vue";
import { useMasterStore } from "@/stores/master";
import { useI18n } from "vue-i18n";

const masterStore = useMasterStore();
const { t } = useI18n();

const items = computed(() => {
    const master = masterStore.masterData ?? {};
    const messages = [
        {
            icon: "bi bi-rocket-takeoff-fill",
            text: t("Enroll now — new career-ready batches are open!"),
        },
        {
            icon: "bi bi-mortarboard-fill",
            text: t("Industry-aligned courses with internship & placement support."),
        },
        {
            icon: "bi bi-patch-check-fill",
            text: t("Learn from top-rated instructors and grow your skills."),
        },
        {
            icon: "bi bi-briefcase-fill",
            text: t("Build job-ready skills with hands-on training programs."),
        },
    ];

    if (master.total_courses) {
        messages.push({
            icon: "bi bi-journal-bookmark-fill",
            text: t("{count}+ courses available to explore.", { count: master.total_courses }),
        });
    }

    if (master.total_student) {
        messages.push({
            icon: "bi bi-people-fill",
            text: t("Join {count}+ learners already growing with us.", { count: master.total_student }),
        });
    }

    if (master.hero_subtitle) {
        messages.unshift({
            icon: "bi bi-stars",
            text: master.hero_subtitle,
        });
    }

    return messages;
});

const duration = computed(() => Math.max(24, items.value.length * 8));
</script>

<style scoped lang="scss">
.home-marquee {
    display: flex;
    align-items: stretch;
    background: linear-gradient(90deg, #052e16 0%, #14532d 50%, #052e16 100%);
    border-bottom: 1px solid rgba(134, 239, 172, 0.2);
    overflow: hidden;
}

.home-marquee__label {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    flex-shrink: 0;
    padding: 0.65rem 1rem;
    background: rgba(34, 197, 94, 0.2);
    color: #bbf7d0;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    white-space: nowrap;
    border-right: 1px solid rgba(134, 239, 172, 0.15);

    i {
        color: #fbbf24;
        font-size: 0.9rem;
    }
}

.home-marquee__track-wrap {
    flex: 1;
    overflow: hidden;
    position: relative;
    mask-image: linear-gradient(90deg, transparent, #000 2%, #000 98%, transparent);
}

.home-marquee__track {
    display: flex;
    width: max-content;
    animation: marquee-scroll var(--marquee-duration, 32s) linear infinite;

    &:hover {
        animation-play-state: paused;
    }
}

.home-marquee__content {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    padding: 0.65rem 0;
}

.home-marquee__item {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0 1.75rem;
    color: rgba(255, 255, 255, 0.92);
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;

    i {
        color: #4ade80;
        font-size: 0.85rem;
    }
}

.home-marquee__dot {
    margin-left: 0.75rem;
    color: rgba(134, 239, 172, 0.5);
}

@keyframes marquee-scroll {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
}

@media (max-width: 575px) {
    .home-marquee__label span {
        display: none;
    }

    .home-marquee__label {
        padding: 0.65rem 0.75rem;
    }

    .home-marquee__item {
        font-size: 0.82rem;
        padding: 0 1.25rem;
    }
}
</style>
