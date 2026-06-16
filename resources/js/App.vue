<template>
    <component :is="$route.meta.layout">
        <RouterView v-slot="{ Component }">
            <Transition
                name="page-fade"
                mode="out-in"
            >
                <component :is="Component" />
            </Transition>
        </RouterView>
    </component>
</template>

<style>
/* Page transition animations */
.page-fade-enter-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.page-fade-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.page-fade-enter-from {
    opacity: 0;
    transform: translateY(12px);
}
.page-fade-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}
</style>
