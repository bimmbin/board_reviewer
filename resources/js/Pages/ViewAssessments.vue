<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link } from "@inertiajs/vue3";
import { format } from "date-fns";
import RetakeExam from "@/Components/RetakeExam.vue";

const { assessments } = defineProps({
    assessments: Object,
});

const formatDate = (dateString) => {
    return format(new Date(dateString), "MMMM dd, yyyy"); // Customize the format as needed
};
const formatTime = (dateString) => {
    return format(new Date(dateString), "hh:mm a"); // Customize the format as needed
};
</script>

<template>
    <div
        class="text-3xl mb-3 font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl flex items-center"
    >
        Assessments
    </div>
    <div class="w-full pb-10 overflow-x-auto">
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px]  xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500  text-start text-btn bg-main_bg text-white"
                >
                    <th class="text-left pl-5 py-5 font-semibold">Name</th>
                    <th class="text-left pl-5 py-5 font-semibold">Major</th>
                    <th class="text-left pl-5 py-5 font-semibold">Date</th>
                    <th class="text-left pl-5 font-semibold">Time</th>
                    <!-- <th class="text-left py-5 font-semibold">Time taken</th> -->
                    <th class="text-left pl-5 font-semibold">Score</th>
                    <th class="text-left pl-5 font-semibold">Score</th>
                    <th class="text-left pl-5 font-semibold">Total</th>
                    <th class="text-left pl-5 font-semibold">Status</th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr
                    v-for="(assessment, index) in assessments"
                    :key="index"
                    class="border border-blue-300 text-sm font-regular whitespace-nowrap"
                >
                    <td class="pl-5 py-4 max-md:px-5">
                        {{ assessment.first_name }} {{ assessment.last_name }} 
                    </td>

                    <td class="pl-5 py-3 max-md:px-5">
                        {{ assessment.major }}
                    </td>

                    <td class="pl-5 py-3 max-md:px-5">
                        {{ formatDate(assessment.updated_at) }}
                    </td>

                    <td class="pl-5 py-3 max-md:px-5">
                        {{ formatTime(assessment.updated_at) }}
                    </td>
                    <!-- looping through the exam coverage -->
                    <td class="pl-5 py-3 max-md:px-5" v-for="exam_cover in assessment.exam_scores">
                        {{ exam_cover }}
                    </td>
                    <td class="pl-5 py-3 max-md:px-5">{{ assessment.total_score }}%</td>
                    <td class="pl-5 max-md:px-5">
                        <span
                            v-if="assessment.total_score >= 75"
                            class="px-3 py-2 bg-green-300 text-green-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >Passed</span
                        >
                        <span
                            v-else
                            class=" px-3 py-2 bg-red-300 text-red-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >Failed</span
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
