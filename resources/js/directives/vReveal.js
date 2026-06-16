/**
 * v-reveal — Scroll-reveal Vue directive
 *
 * Usage:
 *   <div v-reveal.reveal-up>            — slide up when entering viewport
 *   <div v-reveal.reveal-left>          — slide from left
 *   <div v-reveal.reveal-right>         — slide from right
 *   <div v-reveal.reveal-scale>         — scale up
 *   <div v-reveal.reveal-up.delay-200>  — same with 200ms stagger delay
 *
 * The element gains the 'revealed' class once, then the observer disconnects.
 */

const vReveal = {
    mounted(el, binding) {
        // Extract modifier classes from the binding (e.g. reveal-up, reveal-left, delay)
        const modifiers = Object.keys(binding.modifiers);

        // Apply transition classes from modifiers
        modifiers.forEach((mod) => {
            if (mod === 'delay') {
                // Handle delay modifier — use the value if provided, else default 200ms
                const delayMs = binding.arg || '200';
                el.style.transitionDelay = `${delayMs}ms`;
            } else if (mod.startsWith('reveal-') || mod.startsWith('delay-')) {
                el.classList.add(mod);
            }
        });

        // Also honour a plain string value, e.g. v-reveal="'reveal-up'"
        if (binding.value && typeof binding.value === 'string') {
            binding.value.split(/\s+/).forEach((cls) => el.classList.add(cls));
        }

        // Intersection Observer — one-shot reveal
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    el.classList.add('revealed');
                    observer.disconnect();
                }
            },
            {
                threshold: 0.1,
                rootMargin: '-50px 0px',
            }
        );

        observer.observe(el);

        // Store reference so we can clean up if the element is removed before reveal
        el._revealObserver = observer;
    },

    unmounted(el) {
        if (el._revealObserver) {
            el._revealObserver.disconnect();
            delete el._revealObserver;
        }
    },
};

export default vReveal;
