<template>
    <div class="wrapper" @contextmenu="handleContextMenu">
        <header class="site-header" :class="{ 'site-header--home': isHomePage }">
            <Header />
        </header>
        <main
            class="flex-grow-1 d-flex flex-column site-main"
            :class="{ 'site-main--home': isHomePage }"
        >
            <!-- WhatsApp Support -->
            <div v-if="masterStore?.masterData?.whatsapp_support_number != ''"
                class="position-fixed bottom-0 end-0 mb-4 me-4" style="z-index: 99;">
                <!-- Message Bubble -->
                <a v-if="masterStore?.masterData?.whatsapp_support_title"
                    :href="masterStore?.masterData?.whatsapp_support_number" target="_blank"
                    class="bg-light-primary text-primary px-3 py-2 rounded-2 shadow-sm mb-2 text-decoration-none position-absolute"
                    style="bottom: 60px; right: 0; white-space: nowrap; font-size: 14px;">
                    {{ masterStore?.masterData?.whatsapp_support_title }} 💬
                    <span class="bubble-arrow"></span>
                </a>

                <!-- WhatsApp Button -->
                <a :href="masterStore?.masterData?.whatsapp_support_number" target="_blank"
                    class="d-flex align-items-center justify-content-center rounded-circle bg-white border border-2 border-success shadow-sm"
                    style="width: 50px; height: 50px; cursor: pointer;">
                    <img src="/public/whatsapp/support.svg" alt="Logo" style="width: 22px; height: 22px;">
                </a>
            </div>
            <!-- WhatsApp Support -->
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import { useMasterStore } from "@/stores/master";
import { useRoute } from "vue-router";
import { computed } from "vue";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";

const masterStore = useMasterStore();
const route = useRoute();

const isHomePage = computed(() => route.path === "/");

const handleContextMenu = (event) => {
    if (route.path.startsWith("/play")) {
        event.preventDefault();
    }
};
</script>

<style scoped>
.wrapper {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    justify-content: space-between;
}

.site-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1040;
    padding: 0 13px 13px 13px;
    border-radius: 9px;
}

.site-header--home {
    background: transparent;
}

.site-main {
    padding-top: 66px;
}

.site-main--home {
    padding-top: 0;
}

.bubble-arrow {
    position: absolute;
    bottom: -8px;
    right: 15px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 8px solid #e8f0ea;
    /* same as bg-dark */
}
</style>
