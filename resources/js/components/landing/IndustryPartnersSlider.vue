<template>
    <section class="py-14 bg-white overflow-hidden border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <SectionHeader
                :eyebrow="$t('Trusted By')"
                icon="bi bi-award-fill"
                :subtitle="$t('Our students work at the world\'s leading technology companies.')"
            >
                <template #title>
                    {{ $t('Industry') }}
                    <span class="gradient-text">{{ $t('Partners') }}</span>
                </template>
            </SectionHeader>
        </div>

        <!-- Row 1 — scrolling left -->
        <div class="relative overflow-hidden mb-5">
            <div class="flex w-max animate-partner-scroll">
                <div
                    v-for="(partner, i) in [...allPartners, ...allPartners]"
                    :key="`r1-${i}`"
                    class="flex-shrink-0 h-16 flex items-center justify-center mx-4 md:mx-6"
                >
                    <div class="partner-logo-card group cursor-default flex items-center justify-center gap-3 w-32 md:w-40 h-12">
                        <img :src="partner.logo" :alt="partner.name" class="w-8 h-8 object-contain transition-all duration-300" />
                        <span class="font-bold text-sm tracking-wide" :style="{ color: partner.color }">{{ partner.name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 — scrolling right (reverse) -->
        <div class="relative overflow-hidden">
            <div class="flex w-max animate-partner-scroll-reverse">
                <div
                    v-for="(partner, i) in [...allPartners.slice(8), ...allPartners.slice(0, 8), ...allPartners.slice(8), ...allPartners.slice(0, 8)]"
                    :key="`r2-${i}`"
                    class="flex-shrink-0 h-16 flex items-center justify-center mx-4 md:mx-6"
                >
                    <div class="partner-logo-card group cursor-default flex items-center justify-center gap-3 w-32 md:w-40 h-12">
                        <img :src="partner.logo" :alt="partner.name" class="w-8 h-8 object-contain transition-all duration-300" />
                        <span class="font-bold text-sm tracking-wide" :style="{ color: partner.color }">{{ partner.name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import SectionHeader from "./SectionHeader.vue";

const allPartners = [
    { name: "Google", color: "#4285F4", logo: "https://cdn.simpleicons.org/google/4285F4" },
    { name: "Microsoft", color: "#00A4EF", logo: "https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg" },
    { name: "Amazon", color: "#FF9900", logo: "https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" },
    { name: "Meta", color: "#0668E1", logo: "https://cdn.simpleicons.org/meta/0668E1" },
    { name: "Apple", color: "#555555", logo: "https://cdn.simpleicons.org/apple/555555" },
    { name: "Netflix", color: "#E50914", logo: "https://cdn.simpleicons.org/netflix/E50914" },
    { name: "IBM", color: "#0530AD", logo: "https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg" },
    { name: "Intel", color: "#0071C5", logo: "https://cdn.simpleicons.org/intel/0071C5" },
    { name: "Oracle", color: "#C74634", logo: "https://upload.wikimedia.org/wikipedia/commons/5/50/Oracle_logo.svg" },
    { name: "SAP", color: "#008FD3", logo: "https://cdn.simpleicons.org/sap/008FD3" },
    { name: "Accenture", color: "#A100FF", logo: "https://cdn.simpleicons.org/accenture/A100FF" },
    { name: "Deloitte", color: "#86BC25", logo: "https://upload.wikimedia.org/wikipedia/commons/e/ed/Logo_of_Deloitte.svg" },
    { name: "Cisco", color: "#1BA0D7", logo: "https://cdn.simpleicons.org/cisco/1BA0D7" },
    { name: "Salesforce", color: "#00A1E0", logo: "https://upload.wikimedia.org/wikipedia/commons/f/f9/Salesforce.com_logo.svg" },
    { name: "Adobe", color: "#FF0000", logo: "https://upload.wikimedia.org/wikipedia/commons/6/6e/Adobe_Corporate_logo.svg" },
    { name: "HP", color: "#0096D6", logo: "https://cdn.simpleicons.org/hp/0096D6" }
];
</script>

<style scoped>
.partner-logo-card {
    opacity: 0.85;
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.partner-logo-card:hover {
    opacity: 1;
    transform: scale(1.08);
}

.animate-partner-scroll {
    animation: partner-scroll 35s linear infinite;
}

.animate-partner-scroll-reverse {
    animation: partner-scroll-reverse 40s linear infinite;
}

@keyframes partner-scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes partner-scroll-reverse {
    0% { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}
</style>
