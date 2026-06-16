<template>
    <div class="wrapper">
        <div class="main flex-grow-1 flex flex-col justify-center">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    justify-content: space-between;
}

</style>
