<template>
    <section v-if="displayLogos.length" class="industry-partners">
        <div class="container">
            <SectionHeader
                class="industry-partners__header"
                :eyebrow="$t('Trusted By Industry')"
                icon="bi bi-buildings-fill"
                :subtitle="$t('Partnering with leading companies to deliver real-world learning experiences.')"
            >
                <template #title>
                    {{ $t('Industry') }}
                    <span class="accent">{{ $t('Partnerships') }}</span>
                </template>
            </SectionHeader>
        </div>

        <div class="industry-partners__rows">
            <div class="industry-partners__row industry-partners__row--forward">
                <div
                    class="industry-partners__track"
                    :style="{ '--scroll-duration': `${forwardDuration}s` }"
                >
                    <div class="industry-partners__strip">
                        <div
                            v-for="(logo, index) in rowOne"
                            :key="`row1-a-${logo.id}-${index}`"
                            class="industry-partners__item"
                        >
                            <img
                                :src="logo.logo"
                                :alt="logo.name"
                                class="industry-partners__logo"
                                loading="lazy"
                            />
                        </div>
                    </div>
                    <div class="industry-partners__strip" aria-hidden="true">
                        <div
                            v-for="(logo, index) in rowOne"
                            :key="`row1-b-${logo.id}-${index}`"
                            class="industry-partners__item"
                        >
                            <img
                                :src="logo.logo"
                                :alt="logo.name"
                                class="industry-partners__logo"
                                loading="lazy"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="industry-partners__row industry-partners__row--reverse">
                <div
                    class="industry-partners__track"
                    :style="{ '--scroll-duration': `${reverseDuration}s` }"
                >
                    <div class="industry-partners__strip">
                        <div
                            v-for="(logo, index) in rowTwo"
                            :key="`row2-a-${logo.id}-${index}`"
                            class="industry-partners__item"
                        >
                            <img
                                :src="logo.logo"
                                :alt="logo.name"
                                class="industry-partners__logo"
                                loading="lazy"
                            />
                        </div>
                    </div>
                    <div class="industry-partners__strip" aria-hidden="true">
                        <div
                            v-for="(logo, index) in rowTwo"
                            :key="`row2-b-${logo.id}-${index}`"
                            class="industry-partners__item"
                        >
                            <img
                                :src="logo.logo"
                                :alt="logo.name"
                                class="industry-partners__logo"
                                loading="lazy"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.industry-partners {
    padding: 3rem 0;
    background: #fff;
    overflow: hidden;
}

.industry-partners__header {
    margin-bottom: 2rem;
}

.industry-partners__rows {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.industry-partners__row {
    overflow: hidden;
    mask-image: linear-gradient(90deg, transparent, #000 4%, #000 96%, transparent);
}

.industry-partners__track {
    display: flex;
    flex-wrap: nowrap;
    width: max-content;
    will-change: transform;
}

.industry-partners__row--forward .industry-partners__track {
    animation: industry-scroll-forward var(--scroll-duration, 36s) linear infinite;
}

.industry-partners__row--reverse .industry-partners__track {
    animation: industry-scroll-reverse var(--scroll-duration, 40s) linear infinite;
}

.industry-partners__row:hover .industry-partners__track {
    animation-play-state: paused;
}

.industry-partners__strip {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    flex-wrap: nowrap;
    gap: 1.25rem;
    padding: 0.35rem 0.75rem;
}

.industry-partners__item {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 150px;
    height: 72px;
    padding: 0.65rem 1.25rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;

    &:hover {
        transform: translateY(-2px);
        border-color: rgba(34, 197, 94, 0.25);
        box-shadow: 0 8px 22px rgba(21, 128, 61, 0.1);
    }
}

.industry-partners__logo {
    display: block;
    max-width: 120px;
    max-height: 44px;
    width: auto;
    height: auto;
    object-fit: contain;
    filter: grayscale(15%);
    opacity: 0.9;
    transition: filter 0.25s ease, opacity 0.25s ease;
}

.industry-partners__item:hover .industry-partners__logo {
    filter: grayscale(0%);
    opacity: 1;
}

@keyframes industry-scroll-forward {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
}

@keyframes industry-scroll-reverse {
    0% {
        transform: translateX(-50%);
    }

    100% {
        transform: translateX(0);
    }
}

@media (max-width: 767px) {
    .industry-partners {
        padding: 2rem 0;
    }

    .industry-partners__header {
        margin-bottom: 1.5rem;
    }

    .industry-partners__item {
        min-width: 120px;
        height: 60px;
        padding: 0.5rem 1rem;
    }

    .industry-partners__logo {
        max-width: 96px;
        max-height: 36px;
    }
}
</style>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import SectionHeader from "./SectionHeader.vue";

const logos = ref([]);
const viewportWidth = ref(typeof window !== "undefined" ? window.innerWidth : 1280);

const ITEM_SLOT_WIDTH = 182;

const displayLogos = computed(() =>
    logos.value
        .filter((item) => item.logo)
        .sort((a, b) => (a.sort_order ?? 0) - (b.sort_order ?? 0))
);

const minStripItems = computed(() =>
    Math.max(12, Math.ceil((viewportWidth.value * 1.4) / ITEM_SLOT_WIDTH))
);

const fillStrip = (items) => {
    if (!items.length) {
        return [];
    }

    let result = [...items];
    while (result.length < minStripItems.value) {
        result = [...result, ...items];
    }

    return result;
};

const rowOne = computed(() => {
    const items = displayLogos.value;
    if (!items.length) {
        return [];
    }

    if (items.length <= 8) {
        return fillStrip(items);
    }

    const midpoint = Math.ceil(items.length / 2);
    return fillStrip(items.slice(0, midpoint));
});

const rowTwo = computed(() => {
    const items = displayLogos.value;
    if (!items.length) {
        return [];
    }

    if (items.length <= 8) {
        const offset = Math.max(1, Math.floor(items.length / 3));
        const rotated = [...items.slice(offset), ...items.slice(0, offset)];
        return fillStrip(rotated);
    }

    const midpoint = Math.ceil(items.length / 2);
    const secondRow = items.slice(midpoint);
    return fillStrip(secondRow.length ? secondRow : items);
});

const forwardDuration = computed(() => Math.max(28, rowOne.value.length * 4));
const reverseDuration = computed(() => Math.max(32, rowTwo.value.length * 4.5));

const updateViewportWidth = () => {
    viewportWidth.value = window.innerWidth;
};

onMounted(async () => {
    updateViewportWidth();
    window.addEventListener("resize", updateViewportWidth);

    try {
        const response = await axios.get("/home/industry-partners");
        logos.value = response.data.data.logos ?? [];
    } catch (error) {
        console.error("Error fetching industry partners:", error);
    }
});

onUnmounted(() => {
    window.removeEventListener("resize", updateViewportWidth);
});
</script>
