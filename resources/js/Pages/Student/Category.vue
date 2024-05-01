<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Head } from "@inertiajs/vue3";

import CategoryCard from "@/Components/CategoryCard.vue";
import StudentLessonCard from "@/Components/Student/StudentLessonCard.vue";

const { majors } = defineProps({
    majors: Object,
});
</script>

<template>
    <Head title="Student Lessons" />

    <h1 class="mb-5 text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2">
        Lessons
    </h1>
    <div class="flex flex-col w-full gap-2">
        <div v-for="(major, index) in majors">
            <StudentLessonCard v-if="index == 0" :major="major" :show="true" />
            <StudentLessonCard v-else :major="major" />
        </div>
    </div>
</template>
