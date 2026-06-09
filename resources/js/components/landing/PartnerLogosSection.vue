<template>
    <section class="partner-logos" :class="{ 'partner-logos--attached': attached }">
        <div class="container">
            <div class="partners-section">
                <div class="partners-header text-center mb-4 mb-lg-5">
                    <span class="partners-eyebrow">
                        {{ $t('Trusted Network') }}
                    </span>
                    <h3 class="partners-title fw-bold fs-1 mt-3 mb-0">
                        {{ $t('Our') }} <span class="partners-title-accent">{{ $t('Partners') }}</span>
                    </h3>
                </div>

                <div v-if="logos.length" class="partners-marquee">
                    <div class="partners-marquee-row">
                        <div
                            class="partners-marquee-track"
                            :style="{ '--marquee-duration': `${marqueeDuration}s` }"
                        >
                            <div
                                v-for="copy in 2"
                                :key="copy"
                                class="partners-marquee-content"
                                :aria-hidden="copy === 2 ? 'true' : undefined"
                            >
                                <component
                                    v-for="(item, index) in logos"
                                    :key="`${copy}-${item.id ?? index}`"
                                    :is="item.website_url ? 'a' : 'div'"
                                    :href="item.website_url || undefined"
                                    :target="item.website_url ? '_blank' : undefined"
                                    :rel="item.website_url ? 'noopener noreferrer' : undefined"
                                    class="partner-logo-card"
                                    :title="item.name"
                                >
                                    <img
                                        :src="item.logo"
                                        :alt="item.name"
                                        class="partner-logo-card__img"
                                        loading="lazy"
                                    />
                                </component>
                            </div>
                        </div>
                    </div>
                </div>

                <p v-else class="partners-empty text-center mb-0">
                    {{ $t('Partner logos coming soon.') }}
                </p>
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.partner-logos {
    padding: 0;
    background: #0a0a0a;
    overflow: hidden;

    &--attached {
        margin-top: 0;

        .partners-header {
            padding-top: 2rem;
        }
    }
}

.partners-section {
    padding: 0;
    border-radius: 0;
    background: transparent;
}

.partners-header {
    padding: 2.5rem 0 1.5rem;
}

.partners-eyebrow {
    display: inline-block;
    color: #ef4444;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    margin-bottom: 0.25rem;
}

.partners-title {
    color: #fff;
    letter-spacing: -0.02em;
}

.partners-title-accent {
    color: #fff;
}

.partners-marquee {
    overflow: hidden;
    padding-bottom: 2.5rem;
    mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);
}

.partners-marquee-row {
    overflow: hidden;
    width: 100%;
}

.partners-marquee-track {
    display: flex;
    width: max-content;
    animation: partners-scroll-left var(--marquee-duration, 40s) linear infinite;

    &:hover {
        animation-play-state: paused;
    }
}

.partners-marquee-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 0 0.625rem;
    flex-shrink: 0;
}

.partner-logo-card {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 200px;
    height: 88px;
    padding: 1rem 1.25rem;
    border-radius: 16px;
    background: #fff;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    text-decoration: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease;

    &:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.35);
    }
}

.partner-logo-card__img {
    max-width: 100%;
    max-height: 52px;
    width: auto;
    height: auto;
    object-fit: contain;
}

.partners-empty {
    padding: 2.5rem 0;
    color: rgba(255, 255, 255, 0.55);
    font-size: 0.95rem;
}

@keyframes partners-scroll-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

@media (max-width: 767px) {
    .partners-title {
        font-size: 1.75rem !important;
    }

    .partner-logo-card {
        width: 160px;
        height: 76px;
        padding: 0.75rem 1rem;
        border-radius: 14px;
    }

    .partner-logo-card__img {
        max-height: 44px;
    }

    .partners-marquee-content {
        gap: 1rem;
    }
}
</style>

<script setup>
import { ref, computed, onMounted } from "vue";

defineProps({
    attached: {
        type: Boolean,
        default: false,
    },
});

const logos = ref([]);

const marqueeDuration = computed(() => Math.max(28, logos.value.length * 6));

onMounted(async () => {
    try {
        const response = await axios.get("/home/partner-logos");
        logos.value = response.data.data.logos ?? [];
    } catch (error) {
        console.error("Error fetching partner logos:", error);
    }
});
</script>
