<template>
    <section v-if="displayLogos.length" class="partners-showcase">
        <div class="partners-showcase__mosaic" aria-hidden="true">
            <div
                v-for="(item, index) in mosaicTiles"
                :key="`tile-${index}`"
                class="partners-showcase__tile"
                :class="`partners-showcase__tile--${index + 1}`"
                :style="{ backgroundImage: `url(${item.logo})` }"
            ></div>
        </div>

        <div class="partners-showcase__overlay" aria-hidden="true"></div>
        <div class="partners-showcase__glow partners-showcase__glow--left" aria-hidden="true"></div>
        <div class="partners-showcase__glow partners-showcase__glow--right" aria-hidden="true"></div>

        <div class="container partners-showcase__content">
            <div class="partners-showcase__header text-center">
                <span class="partners-showcase__eyebrow">
                    <i class="bi bi-handshake-fill"></i>
                    {{ $t('Trusted Network') }}
                </span>
                <h2 class="partners-showcase__title">
                    {{ $t('Our') }}
                    <span class="partners-showcase__title-accent">{{ $t('Partners') }}</span>
                </h2>
                <p class="partners-showcase__subtitle">
                    {{ $t('Collaborating with industry leaders and academic institutions to deliver excellence.') }}
                </p>
            </div>

            <div class="partners-showcase__grid">
                <component
                    v-for="(item, index) in displayLogos"
                    :key="item.id ?? index"
                    :is="item.website_url ? 'a' : 'div'"
                    :href="item.website_url || undefined"
                    :target="item.website_url ? '_blank' : undefined"
                    :rel="item.website_url ? 'noopener noreferrer' : undefined"
                    class="partners-showcase__card"
                    :style="{ '--card-delay': `${index * 0.08}s` }"
                    :title="item.name"
                >
                    <div class="partners-showcase__card-photo">
                        <img :src="item.logo" :alt="item.name" loading="lazy" />
                    </div>
                    <div class="partners-showcase__card-body">
                        <span class="partners-showcase__card-type">
                            {{ item.partner_type === 'college' ? $t('College') : $t('Company') }}
                        </span>
                        <h3 class="partners-showcase__card-name">{{ item.name }}</h3>
                    </div>
                </component>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.partners-showcase {
    position: relative;
    min-height: 560px;
    padding: 4.5rem 0 4rem;
    overflow: hidden;
    isolation: isolate;
}

.partners-showcase__mosaic {
    position: absolute;
    inset: 0;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: 1fr;
    z-index: 0;
}

.partners-showcase__tile {
    background-size: cover;
    background-position: center;
    transform: scale(1.06);
    filter: saturate(1.05);
    animation: partnersKenBurns 18s ease-in-out infinite alternate;

    &--1 {
        animation-delay: 0s;
    }
    &--2 {
        animation-delay: -3s;
    }
    &--3 {
        animation-delay: -6s;
    }
    &--4 {
        animation-delay: -9s;
    }
    &--5 {
        animation-delay: -12s;
    }
}

.partners-showcase__overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    background:
        linear-gradient(180deg, rgba(8, 15, 30, 0.72) 0%, rgba(8, 15, 30, 0.88) 45%, rgba(8, 15, 30, 0.94) 100%),
        radial-gradient(ellipse 80% 60% at 50% 0%, rgba(44, 171, 77, 0.22) 0%, transparent 65%);
    backdrop-filter: blur(2px);
}

.partners-showcase__glow {
    position: absolute;
    width: 420px;
    height: 420px;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.35;
    z-index: 1;
    pointer-events: none;

    &--left {
        top: 10%;
        left: -8%;
        background: #2cab4d;
    }

    &--right {
        bottom: 5%;
        right: -6%;
        background: #3b82f6;
    }
}

.partners-showcase__content {
    position: relative;
    z-index: 2;
}

.partners-showcase__header {
    max-width: 720px;
    margin: 0 auto 2.75rem;
}

.partners-showcase__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.18);
    color: #86efac;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.partners-showcase__title {
    margin: 1rem 0 0.75rem;
    color: #fff;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1.15;
}

.partners-showcase__title-accent {
    background: linear-gradient(135deg, #4ade80 0%, #22d3ee 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.partners-showcase__subtitle {
    margin: 0;
    color: rgba(255, 255, 255, 0.72);
    font-size: 1.05rem;
    line-height: 1.65;
}

.partners-showcase__grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1.25rem;
}

.partners-showcase__card {
    display: flex;
    flex-direction: column;
    text-decoration: none;
    border-radius: 20px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.14);
    box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.28),
        inset 0 1px 0 rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(14px);
    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease,
        border-color 0.35s ease;
    animation: partnersCardIn 0.7s ease backwards;
    animation-delay: var(--card-delay, 0s);

    &:hover {
        transform: translateY(-8px);
        border-color: rgba(74, 222, 128, 0.45);
        box-shadow:
            0 28px 50px rgba(0, 0, 0, 0.35),
            0 0 0 1px rgba(74, 222, 128, 0.2);
    }
}

.partners-showcase__card-photo {
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: #111;

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .partners-showcase__card:hover & img {
        transform: scale(1.08);
    }
}

.partners-showcase__card-body {
    padding: 1rem 1rem 1.15rem;
    text-align: center;
}

.partners-showcase__card-type {
    display: inline-block;
    margin-bottom: 0.35rem;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    background: rgba(74, 222, 128, 0.15);
    color: #86efac;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.partners-showcase__card-name {
    margin: 0;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.35;
}

@keyframes partnersKenBurns {
    0% {
        transform: scale(1.06) translate(0, 0);
    }
    100% {
        transform: scale(1.14) translate(-1.5%, -1%);
    }
}

@keyframes partnersCardIn {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 1199px) {
    .partners-showcase__grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .partners-showcase__mosaic {
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
    }

    .partners-showcase__tile--4,
    .partners-showcase__tile--5 {
        display: none;
    }
}

@media (max-width: 767px) {
    .partners-showcase {
        min-height: auto;
        padding: 3rem 0 2.5rem;
    }

    .partners-showcase__mosaic {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(3, 120px);
    }

    .partners-showcase__tile--3 {
        grid-column: span 2;
    }

    .partners-showcase__tile--4,
    .partners-showcase__tile--5 {
        display: block;
    }

    .partners-showcase__grid {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;

        &::-webkit-scrollbar {
            height: 6px;
        }

        &::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 999px;
        }
    }

    .partners-showcase__card {
        flex: 0 0 72%;
        max-width: 280px;
        scroll-snap-align: center;
    }
}
</style>

<script setup>
import { ref, computed, onMounted } from "vue";

const MAX_PARTNERS = 5;

const logos = ref([]);

const displayLogos = computed(() => logos.value.slice(0, MAX_PARTNERS));

const mosaicTiles = computed(() => {
    const items = displayLogos.value;
    if (!items.length) {
        return [];
    }

    const tiles = [...items];
    while (tiles.length < MAX_PARTNERS) {
        tiles.push(items[tiles.length % items.length]);
    }

    return tiles.slice(0, MAX_PARTNERS);
});

onMounted(async () => {
    try {
        const response = await axios.get("/home/partner-logos");
        const fetched = response.data.data.logos ?? [];
        logos.value = fetched
            .sort((a, b) => (a.sort_order ?? 0) - (b.sort_order ?? 0))
            .slice(0, MAX_PARTNERS);
    } catch (error) {
        console.error("Error fetching partner logos:", error);
    }
});
</script>
