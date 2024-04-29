<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref } from "vue";
import apexchart from "vue3-apexcharts";
import { usePage, Head } from "@inertiajs/vue3";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";

const page = usePage();

const { series, categories, quotes, average } = defineProps({
    series: Object,
    quotes: Object,
    categories: Array,
    average: Number,
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
        title: {
            text: "Student Attempts",
        },
    },
    yaxis: {
        title: {
            text: "Score",
        },
        min: 1,
        max: 150,
    },
});

console.log(page.props.ziggy.url);
</script>

<template>
    <Head title="Student Dashboard" />

    <h1 class="mb-5 text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2">
        Dashboard
    </h1>
    <div class="flex flex-col gap-3">
        <div class="flex h-32 gap-3">
            <div
                class="w-60 text-main_bg border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] flex flex-col items-center justify-center gap-3"
            >
                <span
                    class="text-sm font-light text-center capitalize whitespace-nowrap"
                    >Students Average Score</span
                >
                <span class="text-4xl font-bold">{{ average }}%</span>
            </div>
            <div
                class="flex-1 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
            >
                <carousel
                    :items-to-show="1"
                    :autoplay="10000"
                    :wrap-around="true"
                >
                    <slide
                        v-for="quote in quotes"
                        :key="quote.id"
                        class="flex flex-col items-center justify-center gap-2"
                    >
                        <p>
                            {{ quote.quote }}
                        </p>
                        <span class="italic font-light opacity-80"
                            >- {{ quote.author }}</span
                        >
                    </slide>
                </carousel>
            </div>
        </div>
        <div class="flex justify-between gap-3">
            <div
                id="chart"
                class="flex-1 border border-blue-200 rounded-md px-3 py-5 bg-[#F4F8FF]"
            >
                <apexchart
                    type="area"
                    height="450"
                    :options="chartOptions"
                    :series="series"
                ></apexchart>
            </div>
            <!-- <div
                class="w-80 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
            >
                Education is the beacon that illuminates the path to progress,
                the key that unlocks doors of opportunity, and the foundation
                upon which dreams are built.
            </div> -->
        </div>
        <!-- <div
            class="flex-1 border border-blue-200 rounded-md px-10 py-5 bg-[#F4F8FF] text-center text-main_bg"
        >
            Education is the beacon that illuminates the path to progress, the
            key that unlocks doors of opportunity, and the foundation upon which
            dreams are built.
        </div> -->
    </div>
</template>
