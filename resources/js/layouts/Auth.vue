<template>
    <div class="wrapper">
        <DashboardHeader />
        <div class="px-3 flex-grow-1 flex flex-col">
            <main class="h-full flex flex-col flex-grow-1">
                <section class="flex flex-grow-1">
                    <section class="border-r border-slate-200 hidden xl:block w-1/4 xl:w-1/3">
                        <DashboardSidebar />
                    </section>
                    <section class="xl:w-3/4 px-4 pt-3 flex-grow-1" style="background: #F8FAFC;">
                        <button class="xl:hidden border border-primary-600 text-primary-600 px-4 py-2 rounded mt-3"
                            type="button" @click="mobileMenuOpen = true"
                            aria-controls="dashboardMenu">
                            Menu <i class="bi bi-arrow-right-circle"></i>
                        </button>

                        <!-- Mobile Menu -->
                        <Teleport to="body">
                            <div v-if="mobileMenuOpen" class="fixed inset-0 z-50 flex">
                                <div class="absolute inset-0 bg-black/50" @click="mobileMenuOpen = false"></div>
                                <div class="relative w-72 bg-white shadow-xl z-10 flex flex-col">
                                    <div class="p-4 border-b border-slate-200">
                                        <button type="button"
                                            class="border border-primary-600 text-primary-600 px-4 py-2 rounded"
                                            @click="mobileMenuOpen = false" aria-label="Close">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                                    <div class="flex-1 overflow-y-auto p-4">
                                <DashboardMenu />
                            </div>
                        </div>
                            </div>
                        </Teleport>

                        <slot />
                    </section>
                </section>
            </main>
        </div>
        <DashboardFooter />
    </div>
</template>

<script setup>
import { ref } from "vue";
import DashboardFooter from "../components/DashboardFooter.vue";
import DashboardHeader from "../components/DashboardHeader.vue";

import DashboardSidebar from "../components/DashboardSidebar.vue";
import DashboardMenu from "../components/DashboardMenu.vue";

const mobileMenuOpen = ref(false);
</script>

<style scoped>
.wrapper {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    justify-content: space-between;
}
</style>
