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

const { recent_exams } = defineProps({
    recent_exams: Object,
});

const formatDate = (dateString) => {
    return format(new Date(dateString), "MMMM dd, yyyy"); // Customize the format as needed
};
const formatTime = (dateString) => {
    return format(new Date(dateString), "hh:mm a"); // Customize the format as needed
};
</script>

<template>
    <h1
        class="text-3xl font-semibold mb-5 max-md:mt-20 text-blue-800 max-md:mb-2"
    >
        Recent Exams
    </h1>
    <div class="w-full pb-10 overflow-x-auto">
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px] text-lg xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-blue-500 text-white"
                >
                    <th class="text-left pl-5 py-5 font-semibold">Topic</th>
                    <th class="text-left py-5 font-semibold">Date</th>
                    <th class="text-left py-5 font-semibold">Time</th>
                    <th class="text-left py-5 font-semibold">Time taken</th>
                    <th class="text-left py-5 font-semibold">Score</th>
                    <th class="text-left py-5 font-semibold">Status</th>
                    <th class="text-left py-5 font-semibold">Action</th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr
                    v-for="(recent_exam, index) in recent_exams"
                    :key="index"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">
                        {{ recent_exam.category.category_name }}
                    </td>

                    <td>{{ formatDate(recent_exam.created_at) }}</td>
                    <td>
                        {{ formatTime(recent_exam.created_at) }}
                    </td>
                    <td>
                        {{ recent_exam.time_taken }}
                    </td>
                    <td>
                        {{ recent_exam.exam_answers_count }}/{{
                            recent_exam.category.lessons_count
                        }}
                    </td>
                    <td>
                        <span
                            v-if="
                                recent_exam.exam_answers_count >=
                                recent_exam.category.lessons_count * 0.75
                            "
                            class="px-3 py-2 bg-green-300 text-green-800 rounded-md text-sm max-md:text-xs max-md:py-1" >Passed</span
                        >
                        <span v-else class="px-3 py-2 bg-red-300 text-red-800 rounded-md text-sm max-md:text-xs max-md:py-1">Failed</span>
                    </td>
                    <td><RetakeExam :exam="recent_exam"/></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
