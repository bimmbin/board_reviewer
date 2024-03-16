<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref } from "vue";
import apexchart from "vue3-apexcharts";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const { series, categories } = defineProps({
    series: Object,
    categories: Array,
});

const chartOptions = ref({
    chart: {
        height: 350,
        type: "area",
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
    },
    xaxis: {
        categories: categories,
    },
});

console.log(page.props.ziggy.url);
</script>

<template>
    <h1 class="text-3xl font-bold mb-5 max-md:mt-20 text-main_bg max-md:mb-2">
        Dashboard
    </h1>
    <div class="flex flex-col gap-3">
        <div class="flex gap-3">
            <div class="w-60 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF]">

            </div>
            <div
                class="flex-1 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
            >
                Education is the beacon that illuminates the path to progress,
                the key that unlocks doors of opportunity, and the foundation
                upon which dreams are built.
            </div>
        </div>
        <div class="flex justify-between gap-3">
            <div
                id="chart"
                class="flex-1 border border-blue-200 rounded-md px-3 py-5 bg-[#F4F8FF]"
            >
                <apexchart
                    type="area"
                    height="350"
                    :options="chartOptions"
                    :series="series"
                ></apexchart>
            </div>
            <div
                class="w-80 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
            >
                Education is the beacon that illuminates the path to progress,
                the key that unlocks doors of opportunity, and the foundation
                upon which dreams are built.
            </div>
        </div>
        <div
            class="flex-1 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
        >
            Education is the beacon that illuminates the path to progress, the
            key that unlocks doors of opportunity, and the foundation upon which
            dreams are built.
        </div>
    </div>
</template>
