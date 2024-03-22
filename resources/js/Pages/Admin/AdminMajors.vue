<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Head } from "@inertiajs/vue3";
import MajorCard from "@/Components/MajorCard.vue";

const { majors } = defineProps({
    majors: Object,
});
</script>

<template>
    <Head title="Students of every Majors" />

    <div
        class="text-3xl mb-3 font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl flex items-center"
    >
        Students
    </div>
    <div
        class="w-full flex flex-wrap gap-3 max-xl:flex-nowrap max-xl:flex-col max-sm:px-0 justify-stretch"
    >
        <div v-for="major in majors">
            <MajorCard :major="major" />
        </div>
    </div>
</template>
