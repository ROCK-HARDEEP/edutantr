<template>
    <Transition
        enter-active-class="transition-all duration-500 ease-out"
        enter-from-class="translate-x-full opacity-0"
        enter-to-class="translate-x-0 opacity-100"
        leave-active-class="transition-all duration-400 ease-in"
        leave-from-class="translate-x-0 opacity-100"
        leave-to-class="translate-x-full opacity-0"
    >
        <div
            v-if="visible"
            class="fixed bottom-6 left-6 z-50 max-w-sm bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 flex items-center gap-3"
        >
            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                <i class="bi bi-person-fill text-primary-600 text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-navy leading-snug">
                    <span class="text-primary-700">{{ current.name }}</span>
                    from
                    <span class="text-primary-700">{{ current.city }}</span>
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    just enrolled in <span class="font-semibold text-slate-700">{{ current.course }}</span>
                </p>
            </div>
            <button
                @click="visible = false"
                class="ml-2 text-slate-400 hover:text-slate-600 transition-colors shrink-0"
            >
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>
    </Transition>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const activities = [
    { name: "Priya", city: "Mumbai", course: "Full-Stack Development" },
    { name: "Arjun", city: "Delhi", course: "Data Science & AI" },
    { name: "Sneha", city: "Bangalore", course: "Cloud Computing (AWS)" },
    { name: "Rohit", city: "Hyderabad", course: "Cybersecurity Essentials" },
    { name: "Ananya", city: "Pune", course: "UI/UX Design Masterclass" },
    { name: "Vikram", city: "Chennai", course: "DevOps Engineering" },
    { name: "Meera", city: "Kolkata", course: "Python for Data Analytics" },
    { name: "Karthik", city: "Ahmedabad", course: "React & Node.js Bootcamp" },
    { name: "Deepa", city: "Jaipur", course: "Machine Learning Foundations" },
    { name: "Aditya", city: "Lucknow", course: "Digital Marketing Pro" },
    { name: "Nisha", city: "Chandigarh", course: "Blockchain Development" },
    { name: "Rahul", city: "Bhopal", course: "Mobile App Development" },
];

const currentIndex = ref(0);
const current = ref(activities[0]);
const visible = ref(false);
let intervalId = null;

const showNext = () => {
    visible.value = false;
    setTimeout(() => {
        currentIndex.value = (currentIndex.value + 1) % activities.length;
        current.value = activities[currentIndex.value];
        visible.value = true;
    }, 500);
};

onMounted(() => {
    // Show first toast after a short delay
    setTimeout(() => {
        visible.value = true;
    }, 3000);

    // Cycle every 8 seconds
    intervalId = setInterval(showNext, 8000);
});

onUnmounted(() => {
    if (intervalId) clearInterval(intervalId);
});
</script>
