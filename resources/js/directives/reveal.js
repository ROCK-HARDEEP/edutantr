const DEFAULT_ANIMATION = "fadeInUp";
const DEFAULT_THRESHOLD = 0.12;

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const el = entry.target;
            const animation = el.dataset.revealAnimation || DEFAULT_ANIMATION;
            const delay = el.dataset.revealDelay || "0";
            const duration = el.dataset.revealDuration;

            el.classList.remove("reveal-pending");
            el.classList.add("animate__animated", `animate__${animation}`);

            if (delay !== "0") {
                el.style.animationDelay = `${delay}ms`;
            }

            if (duration) {
                el.style.animationDuration = `${duration}ms`;
            }

            observer.unobserve(el);
        });
    },
    {
        threshold: DEFAULT_THRESHOLD,
        rootMargin: "0px 0px -48px 0px",
    }
);

function parseOptions(binding) {
    const animation = binding.arg || DEFAULT_ANIMATION;
    let delay = 0;
    let duration = null;

    if (binding.value && typeof binding.value === "object") {
        delay = binding.value.delay ?? 0;
        duration = binding.value.duration ?? null;

        return {
            animation: binding.value.animation || animation,
            delay,
            duration,
        };
    }

    if (typeof binding.value === "number") {
        delay = binding.value;
    }

    return { animation, delay, duration };
}

function shouldSkipAnimation() {
    return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
}

export const vReveal = {
    mounted(el, binding) {
        const { animation, delay, duration } = parseOptions(binding);

        el.dataset.revealAnimation = animation;
        el.dataset.revealDelay = String(delay);

        if (duration) {
            el.dataset.revealDuration = String(duration);
        }

        if (shouldSkipAnimation()) {
            return;
        }

        el.classList.add("reveal-pending");
        observer.observe(el);
    },

    unmounted(el) {
        observer.unobserve(el);
    },
};
