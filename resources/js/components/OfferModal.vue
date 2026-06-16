<template>
    <!-- Only show if there's a real banner image (not placeholder) -->
    <Teleport to="body">
        <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showModal && banner.thumbnail && !isPlaceholder"
                class="fixed inset-0 z-[1050] flex items-center justify-center"
                style="background: rgba(0,0,0,0.5);"
                @click.self="closeModal"
            >
                <div class="relative bg-white rounded-2xl max-w-[700px] w-[90%] max-h-[80vh] overflow-hidden shadow-2xl animate-[fadeInScale_0.35s_ease-in-out]">
                    <!-- Close Button -->
                    <button
                        @click="closeModal"
                        class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 shadow-md flex items-center justify-center text-slate-600 hover:bg-slate-900 hover:text-white transition-all"
                    >
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>

                    <!-- Banner Image -->
                    <img
                        :src="banner.thumbnail"
                        alt="Offer Banner"
                        class="w-full h-full object-contain block bg-slate-50"
                        @click="handleClick"
                    />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useMasterStore } from "@/stores/master";
import { useRouter } from "vue-router";

const masterStore = useMasterStore();
const router = useRouter();
const showModal = ref(false);
const banner = ref({});

const isPlaceholder = computed(() => {
    const url = banner.value?.thumbnail || "";
    return url.includes("placehold.co") || url.includes("placeholder") || url === "";
});

onMounted(async () => {
    // Only show if banner is enabled AND we can fetch a real image
    if (masterStore?.masterData?.show_banner == 1) {
        try {
            const response = await axios.get("/banner/list");
            banner.value = response.data.data;
            // Only show if there's a real thumbnail
            if (banner.value?.thumbnail && !isPlaceholder.value) {
                showModal.value = true;
            }
        } catch {
            // Don't show modal on error
        }
    }
});

function closeModal() {
    showModal.value = false;
}

const handleClick = () => {
    router.push("/programs");
    showModal.value = false;
};
</script>

<style scoped>
@keyframes fadeInScale {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
</style>
