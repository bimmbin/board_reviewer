<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import ExamCategoryCard from "@/Components/ExamCategoryCard.vue";

const { majors } = defineProps({
    majors: Object,
});
</script>

<template>
    <h1
        class="text-3xl font-bold mb-5 max-md:mt-20 text-main_bg max-md:mb-2"
    >
        Exam
    </h1>
    <div
        class="w-full flex flex-wrap gap-3 max-xl:flex-nowrap max-xl:flex-col max-sm:px-0 justify-stretch"
    >
        <!-- <div v-for="category in categories">
            <ExamCategoryCard :category="category" />
        </div> -->
        <div class="w-full flex gap-3  text-main_bg justify-between">

            <!-- first column -->
            <ExamCategoryCard v-for="major in majors" :major="major"/>

        </div>
    </div>
</template>
