<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import InstructorMajorCard from "@/Components/Instructor/InstructorMajorCard.vue";

const { majors } = defineProps({
    majors: Object,
});
</script>

<template>
    <div
        class="text-3xl mb-3 font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl flex items-center"
    >
        Majors
    </div>
    <div
        class="w-full flex flex-wrap gap-3 max-xl:flex-nowrap max-xl:flex-col max-sm:px-0 justify-stretch"
    >
        <div v-for="major in majors">
            <InstructorMajorCard :major="major" />
        </div>
    </div>
</template>
