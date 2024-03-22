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

    <h1 class="text-3xl font-bold mb-5 max-md:mt-20 text-main_bg max-md:mb-2">
        Lessons
    </h1>
    <div class="w-full flex flex-col gap-2">
        <div v-for="major in majors">
            <StudentLessonCard :major="major"></StudentLessonCard>
        </div>
    </div>
</template>
