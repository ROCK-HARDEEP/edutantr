<template>
    <component
        :is="wrapperTag"
        v-bind="wrapperAttrs"
        class="brand-logo"
        :class="[
            `brand-logo--${size}`,
            `brand-logo--${variant}`,
            { 'brand-logo--centered': centered },
            { 'brand-logo--has-image': !!logoSrc },
        ]"
        :aria-label="logoAlt"
    >
        <img
            v-if="logoSrc"
            :src="logoSrc"
            :alt="logoAlt"
            class="brand-logo__image"
            :class="{ 'brand-logo__image--icon-only': iconOnly }"
        />
        <template v-else>
            <span class="brand-logo__icon" aria-hidden="true">
                <i class="bi bi-mortarboard-fill"></i>
            </span>
            <span v-if="!iconOnly" class="brand-logo__wordmark">
                <span class="brand-logo__edu">Edu</span><span class="brand-logo__tantr">tantr</span>
            </span>
        </template>
    </component>
</template>

<script setup>
import { computed } from "vue";
import { useMasterStore } from "@/stores/master";

const props = defineProps({
    to: {
        type: String,
        default: "",
    },
    href: {
        type: String,
        default: "",
    },
    src: {
        type: String,
        default: "",
    },
    alt: {
        type: String,
        default: "",
    },
    variant: {
        type: String,
        default: "default",
    },
    size: {
        type: String,
        default: "md",
    },
    centered: {
        type: Boolean,
        default: false,
    },
    iconOnly: {
        type: Boolean,
        default: false,
    },
});

const masterStore = useMasterStore();

const logoSrc = computed(() => props.src || masterStore?.masterData?.logo || "");
const logoAlt = computed(() => props.alt || masterStore?.masterData?.name || "Home");

const wrapperTag = computed(() => {
    if (props.to) {
        return "router-link";
    }

    if (props.href) {
        return "a";
    }

    return "span";
});

const wrapperAttrs = computed(() => {
    if (props.to) {
        return { to: props.to };
    }

    if (props.href) {
        return { href: props.href };
    }

    return {};
});
</script>

<style scoped lang="scss">
.brand-logo {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0;
    text-decoration: none;
    transition: transform 0.25s ease;

    &:hover {
        transform: translateY(-1px);
        text-decoration: none;

        .brand-logo__icon {
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }

        .brand-logo__tantr {
            filter: brightness(1.08);
        }
    }

    &--centered {
        justify-content: center;
    }

    &--has-image:hover {
        transform: translateY(-1px);
    }
}

.brand-logo__image {
    display: block;
    max-height: 44px;
    width: auto;
    max-width: 190px;
    object-fit: contain;

    &--icon-only {
        max-height: 40px;
        max-width: 40px;
    }
}

.brand-logo__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #15803d, #22c55e);
    color: #fff;
    font-size: 1.15rem;
    box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);
    transition: box-shadow 0.25s ease;
    flex-shrink: 0;
}

.brand-logo__wordmark {
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: -0.03em;
}

.brand-logo__edu {
    color: #14532d;
}

.brand-logo__tantr {
    color: #22c55e;
    background: linear-gradient(135deg, #15803d 0%, #22c55e 50%, #4ade80 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.brand-logo--sm {
    gap: 0.5rem;

    .brand-logo__icon {
        width: 32px;
        height: 32px;
        font-size: 0.95rem;
        border-radius: 10px;
    }

    .brand-logo__wordmark {
        font-size: 1.35rem;
    }

    .brand-logo__image {
        max-height: 36px;
        max-width: 160px;
    }
}

.brand-logo--lg {
    gap: 0.75rem;

    .brand-logo__icon {
        width: 48px;
        height: 48px;
        font-size: 1.35rem;
        border-radius: 14px;
    }

    .brand-logo__wordmark {
        font-size: 2rem;
    }

    .brand-logo__image {
        max-height: 56px;
        max-width: 220px;
    }
}

.brand-logo--light {
    .brand-logo__edu {
        color: #ffffff;
    }

    .brand-logo__tantr {
        background: linear-gradient(135deg, #bbf7d0 0%, #4ade80 50%, #86efac 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
}
</style>
