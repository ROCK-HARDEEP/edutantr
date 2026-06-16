<template>
    <div class="bg-white rounded-xl shadow-md">
        <div class="border-b border-slate-200 p-3">
            <small class="block text-left lg:text-right text-slate-400 mb-3 lg:mb-0">{{ $t('Member Since') }}: {{
                instructor.joining_date }}</small>
            <img :src="instructor.profile_picture" class="rounded-full object-cover mr-3 mb-3" height="100px"
                width="100px" />
            <h1 class="font-bold text-xl">{{ instructor.name }}</h1>
            <span>{{ instructor.title
                }}<i class="bi bi-patch-check-fill text-blue-500 ml-2"></i></span>

            <div class="bg-slate-50 p-3 rounded-xl mt-3">
                <small class="block mb-2">{{ $t('Rating & Reviews') }}</small>
                <i class="bi bi-star-fill text-amber-400 mr-2 text-2xl"></i>
                <span class="font-bold text-2xl mr-2">{{
                    instructor.average_rating
                    }}</span>
                <span class="text-slate-400 text-lg">({{ instructor.reviews_count }})</span>
            </div>
        </div>
        <div class="grid grid-cols-3 p-3">
            <div class="border-r border-slate-200 px-2 lg:px-4 py-2 text-center">
                <i class="ri-book-open-fill text-lg text-blue-500 p-2 bg-slate-50 rounded-full inline-block"></i>
                <small class="block mt-3">{{ $t('Courses') }}</small>
                <span class="font-bold text-lg">{{ instructor.course_count }}</span>
            </div>
            <div class="border-r border-slate-200 px-2 lg:px-4 py-2 text-center">
                <i class="ri-contacts-book-fill text-lg text-amber-400 p-2 bg-slate-50 rounded-full inline-block"></i>
                <small class="block mt-3">{{ $t('Enrollments') }}</small>
                <span class="font-bold text-lg">{{ instructor.student_count }}</span>
            </div>
            <div class="px-2 lg:px-4 py-2 text-center">
                <i class="ri-group-2-fill text-lg text-primary-600 p-2 bg-slate-50 rounded-full inline-block"></i>
                <small class="block mt-3">{{ $t('Students') }}</small>
                <span class="font-bold text-lg">{{ instructor.student_count }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

let props = defineProps({
    instructor: Object,
});
</script>
