<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Head } from "@inertiajs/vue3";
import MajorCard from "@/Components/MajorCard.vue";

const { major } = defineProps({
    major: Object,
});
</script>

<template>
    <Head title="Students of every Majors" />

    <div
        class="flex items-center mb-3 text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl"
    >
        Students
    </div>
    <div
        class="flex flex-wrap w-full gap-3 max-xl:flex-nowrap max-xl:flex-col max-sm:px-0 justify-stretch"
    >
        <MajorCard :major="major" />
    </div>
</template>
