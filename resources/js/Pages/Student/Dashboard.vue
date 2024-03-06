<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref } from "vue";
import apexchart from "vue3-apexcharts";

const { majors } = defineProps({
    majors: Object,
});

const series = ref([
    {
        name: "series1",
        data: [31, 40, 28, 51, 42, 109, 100, 126, 145],
    },
    {
        name: "series2",
        data: [11, 32, 45, 32, 34, 52, 41, 60, 100],
    },
]);

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
        type: "datetime",
        categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
            "2018-09-19T07:30:00.000Z",
            "2018-09-19T08:30:00.000Z",
        ],
    },
    tooltip: {
        x: {
            format: "dd/MM/yy HH:mm",
        },
    },
});
</script>

<template>
    <h1 class="text-3xl font-bold mb-5 max-md:mt-20 text-main_bg max-md:mb-2">
        Dashboard
    </h1>
    <div class="flex flex-col gap-3">
        <div
            class="flex-1 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
        >
        Education is the beacon that illuminates the path to progress, the key that unlocks doors of opportunity, and the foundation upon which dreams are built.
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
                Education is the beacon that illuminates the path to progress, the key that unlocks doors of opportunity, and the foundation upon which dreams are built.
            </div>
        </div>
        <div
            class="flex-1 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
        >
        Education is the beacon that illuminates the path to progress, the key that unlocks doors of opportunity, and the foundation upon which dreams are built.
        </div>
    </div>
</template>
