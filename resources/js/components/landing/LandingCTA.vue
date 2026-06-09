<template>
    <section class="landing-cta py-5">
        <div class="container">
            <div class="cta-card">
                <div class="cta-bg-pattern" aria-hidden="true">
                    <i class="bi bi-mortarboard"></i>
                    <i class="bi bi-rocket-takeoff"></i>
                    <i class="bi bi-lightbulb"></i>
                </div>
                <div class="cta-glow" aria-hidden="true"></div>

                <div class="row align-items-center position-relative">
                    <div class="col-lg-7 text-center text-lg-start">
                        <h3 class="cta-title fw-bold mb-2">
                            {{ $t('Share Your Knowledge, Inspire Learners Around the World') }}
                        </h3>
                        <p class="cta-subtitle mb-4 mb-lg-0">
                            {{ $t('Join our community of expert instructors and help shape the next generation of professionals.') }}
                        </p>
                    </div>
                    <div class="col-lg-5 text-center text-lg-end mt-4 mt-lg-0">
                        <router-link to="/register" class="btn cta-btn cta-btn--primary btn-lg rounded-pill px-4 fw-semibold me-2 mb-2 mb-md-0">
                            {{ $t('Get Started') }}
                            <i class="bi bi-arrow-right ms-2"></i>
                        </router-link>
                        <router-link to="/contact-us" class="btn cta-btn cta-btn--outline btn-lg rounded-pill px-4 fw-semibold">
                            {{ $t('Talk To Us') }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.landing-cta {
    background: #f8fafc;
}

.cta-card {
    position: relative;
    overflow: hidden;
    padding: 3rem 2.5rem;
    border-radius: 24px;
    background: linear-gradient(135deg, #052e16 0%, #14532d 40%, #166534 70%, #15803d 100%);
    border: 1px solid rgba(134, 239, 172, 0.2);
    box-shadow: 0 20px 50px rgba(5, 46, 22, 0.3);
}

.cta-bg-pattern {
    position: absolute;
    inset: 0;
    pointer-events: none;

    i {
        position: absolute;
        font-size: clamp(3rem, 8vw, 6rem);
        color: rgba(255, 255, 255, 0.04);
    }

    i:nth-child(1) {
        top: 10%;
        right: 8%;
        transform: rotate(12deg);
    }

    i:nth-child(2) {
        bottom: 10%;
        left: 5%;
        transform: rotate(-8deg);
    }

    i:nth-child(3) {
        top: 40%;
        left: 40%;
        transform: rotate(6deg);
        color: rgba(251, 191, 36, 0.08);
    }
}

.cta-glow {
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(52, 211, 153, 0.25) 0%, transparent 70%);
    filter: blur(60px);
    pointer-events: none;
}

.cta-title {
    color: #fff;
    font-size: clamp(1.35rem, 2.5vw, 1.85rem);
    line-height: 1.35;
}

.cta-subtitle {
    color: rgba(255, 255, 255, 0.78);
    font-size: 1rem;
    max-width: 520px;
}

.cta-btn {
    transition: transform 0.25s ease, box-shadow 0.25s ease;

    &:hover {
        transform: translateY(-2px);
    }
}

.cta-btn--primary {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    border: none;
    color: #1c1917;
    box-shadow: 0 8px 24px rgba(251, 191, 36, 0.35);

    &:hover {
        background: linear-gradient(135deg, #fcd34d, #fbbf24);
        color: #1c1917;
        box-shadow: 0 12px 32px rgba(251, 191, 36, 0.45);
    }
}

.cta-btn--outline {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.45);
    color: #fff;
    backdrop-filter: blur(8px);

    &:hover {
        background: rgba(255, 255, 255, 0.18);
        border-color: #fff;
        color: #fff;
    }
}

@media (max-width: 575px) {
    .cta-card {
        padding: 2rem 1.5rem;
    }

    .cta-btn {
        width: 100%;
    }
}
</style>

<script setup>
</script>
