<template>
    <!-- Popular Variant -->
    <div v-if="variant === 'popular'" class="bg-white rounded-2xl border border-slate-100 overflow-hidden h-full flex flex-col hover:border-orange-100 transition-colors duration-300">
        <router-link :to="`/details/${course.id}`" class="block h-[220px] overflow-hidden">
            <img
                :src="course.thumbnail"
                :alt="course.title"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-400"
            />
        </router-link>

        <div class="flex-1 p-5">
            <!-- Meta: Instructor + Category -->
            <div class="flex items-center justify-between gap-2 mb-3">
                <router-link
                    :to="`/instructor/${course.instructor.id}`"
                    class="inline-flex items-center gap-2 text-slate-500 text-sm font-semibold min-w-0"
                >
                    <img
                        :src="course.instructor.profile_picture"
                        alt=""
                        class="w-8 h-8 rounded-full object-cover"
                    />
                    <span class="truncate">{{ shortName(course.instructor?.name) }}</span>
                </router-link>
                <span class="shrink-0 px-2.5 py-1 rounded-full bg-orange-50 text-orange-600 text-xs font-semibold max-w-[45%] truncate">
                    {{ course.category }}
                </span>
            </div>

            <!-- Title -->
            <router-link
                :to="`/details/${course.id}`"
                class="block text-navy font-bold text-[1.05rem] leading-snug mb-3 line-clamp-2 min-h-[2.95rem] hover:text-primary-700 transition-colors"
            >
                {{ shortText(course.title) }}
            </router-link>

            <!-- Stats -->
            <div class="flex items-center justify-between text-sm text-slate-500 font-semibold mb-3">
                <span class="inline-flex items-center gap-1">
                    <i class="bi bi-play-circle text-slate-400"></i>
                    {{ course.chapter_count }} {{ $t('Lessons') }}
                </span>
                <span class="inline-flex items-center gap-1">
                    <i class="bi bi-clock text-slate-400"></i>
                    {{ formatPopularDuration(course?.total_duration) }}
                </span>
            </div>

            <!-- Tech Badges (NEW per Enhancement Plan) -->
            <div v-if="course.tech_stacks?.length" class="flex flex-wrap gap-1.5 mb-3">
                <span
                    v-for="tech in course.tech_stacks.slice(0, 4)"
                    :key="tech"
                    class="px-2 py-0.5 rounded-md bg-tech-blue/10 text-tech-blue text-[0.7rem] font-semibold"
                >
                    {{ tech }}
                </span>
            </div>

            <!-- Difficulty Level (NEW per Enhancement Plan) -->
            <div v-if="course.difficulty_level" class="mb-1">
                <span
                    class="px-2 py-0.5 rounded-md text-[0.7rem] font-bold uppercase tracking-wider"
                    :class="difficultyClass"
                >
                    {{ course.difficulty_level }}
                </span>
            </div>
        </div>

        <!-- Footer: Rating -->
        <div class="flex items-center justify-center px-5 py-3 bg-slate-50 border-t border-slate-100 mt-auto">
            <span class="inline-flex items-center gap-1.5 text-sm text-slate-500">
                <i class="bi bi-star-fill text-amber-400 text-sm"></i>
                <strong class="text-slate-700">{{ course.average_rating }}</strong>
                ({{ course.review_count }})
            </span>
        </div>
    </div>

    <!-- Default Variant -->
    <div v-else class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full hover:border-primary-200/30 hover:shadow-lg transition-all duration-350">
        <router-link :to="`/details/${course.id}`" class="block relative h-[200px] overflow-hidden">
            <img
                :src="course.thumbnail"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-400"
                alt=""
            />
            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-gradient-to-r from-primary-700 to-primary-500 text-white text-[11px] font-semibold shadow-lg shadow-primary-700/30">
                {{ course.category }}
            </span>
        </router-link>

        <div class="p-4 pb-0">
            <!-- Duration & Lessons -->
            <div class="flex items-center justify-between text-sm font-semibold text-slate mb-2">
                <span class="flex items-center gap-2">
                    <i class="bi bi-mortarboard"></i>
                    {{ course.chapter_count }} {{ $t('Classes') }}
                </span>
                <span class="flex items-center gap-2">
                    <i class="bi bi-clock text-amber-500"></i>
                    {{ formatDuration(course?.total_duration) }}
                </span>
            </div>

            <!-- Title -->
            <router-link :to="`/details/${course.id}`" class="block mb-2">
                <p class="font-bold text-navy text-base leading-snug line-clamp-2 hover:text-primary-700 transition-colors">
                    {{ shortText(course.title) }}
                </p>
            </router-link>

            <!-- Price -->
            <div class="flex items-center gap-2 mb-3 mt-3">
                <template v-if="!course?.is_free && !course?.is_enrolled">
                    <strong class="text-primary-700 text-xl">
                        <span v-if="masterStore?.masterData?.currency_position == 'Left'">
                            {{ masterStore?.masterData?.currency_symbol }}{{ course.price ?? course.regular_price }}
                        </span>
                        <span v-else>
                            {{ course.price ?? course.regular_price }}{{ masterStore?.masterData?.currency_symbol }}
                        </span>
                    </strong>
                    <span v-if="course?.price" class="text-slate-400 text-sm line-through">
                        <span v-if="masterStore?.masterData?.currency_position == 'Left'">
                            {{ masterStore?.masterData?.currency_symbol }}{{ course.regular_price }}
                        </span>
                        <span v-else>
                            {{ course.regular_price }}{{ masterStore?.masterData?.currency_symbol }}
                        </span>
                    </span>
                </template>
                <template v-else>
                    <span
                        class="px-3 py-1.5 rounded-lg text-sm font-semibold"
                        :class="course?.is_enrolled
                            ? 'bg-primary-500 text-white'
                            : 'bg-primary-50 text-primary-700 border border-primary-200'"
                    >
                        {{ course?.is_enrolled ? $t('Enrolled') : $t('Free') }}
                    </span>
                </template>
            </div>
        </div>

        <!-- Footer: Instructor + Rating -->
        <div class="flex items-center justify-between px-4 py-3 bg-slate-50 border-t border-slate-100 mt-auto">
            <router-link
                :to="`/instructor/${course.instructor.id}`"
                class="flex items-center gap-2 text-slate-500 hover:text-primary-700 transition-colors"
            >
                <img
                    :src="course.instructor.profile_picture"
                    alt=""
                    class="w-8 h-8 rounded-full object-cover"
                />
                <span class="font-bold text-sm">{{ shortName(course.instructor?.name) }}</span>
            </router-link>
            <span class="flex items-center gap-1 text-sm">
                <i class="bi bi-star-fill text-amber-400 text-sm"></i>
                <strong class="text-slate-700">{{ course.average_rating }}</strong>
                <span class="text-slate-400">({{ course.review_count }})</span>
            </span>
        </div>
    </div>
</template>

<script setup>
import { useMasterStore } from "@/stores/master";
import { computed } from "vue";

const masterStore = useMasterStore();

const props = defineProps({
    course: Object,
    variant: { type: String, default: "default" },
});

const difficultyClass = computed(() => {
    const level = props.course?.difficulty_level?.toLowerCase();
    if (level === "beginner") return "bg-green-50 text-green-700";
    if (level === "intermediate") return "bg-amber-50 text-amber-700";
    return "bg-red-50 text-red-700";
});

function shortText(text) {
    const width = window.innerWidth;
    const maxLength = width <= 576 ? 20 : 60;
    return text.length > maxLength ? text.slice(0, maxLength) + "..." : text;
}

const shortName = (name) => {
    if (!name) return "";
    const names = name.split(" ");
    if (names.length === 1) return names[0];
    return names[0] + " " + names[names.length - 1];
};

const formatDuration = (duration) => {
    if (duration >= 60) {
        const hours = Math.floor(duration / 60);
        const minutes = duration % 60;
        return `${hours} hour${hours > 1 ? "s" : ""}${minutes > 0 ? ` ${minutes} min` : ""}`;
    }
    return `${duration} min`;
};

const formatPopularDuration = (duration) => {
    const total = Number(duration) || 0;
    const hours = Math.floor(total / 60);
    const minutes = total % 60;
    return `${String(hours).padStart(2, "0")} HRS ${String(minutes).padStart(2, "0")} Mins`;
};
</script>
