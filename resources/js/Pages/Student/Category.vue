<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import CategoryCard from "@/Components/CategoryCard.vue";

const { categories } = defineProps({
    categories: Object,
});
</script>

<template>
  <h1 class="text-3xl font-semibold mb-5 max-md:mt-20 text-blue-800 max-md:mb-2">Topics</h1>
    <div
        class="w-full flex flex-wrap gap-3 max-xl:flex-nowrap max-xl:flex-col max-sm:px-0 justify-stretch"
    >
        <div v-for="category in categories">
            <CategoryCard :category="category" />
        </div>
    </div>
</template>
