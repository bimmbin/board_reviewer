<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Head } from "@inertiajs/vue3";
import { format } from "date-fns";
import RetakeExam from "@/Components/RetakeExam.vue";

const { assessments, exam_coverage } = defineProps({
    assessments: Object,
    exam_coverage: Object,
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
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px] text-lg xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-main_bg text-white"
                >
                    <th class="text-left pl-5 py-5 font-semibold">Date</th>
                    <th class="text-left py-5 font-semibold">Time</th>
                    <!-- <th class="text-left py-5 font-semibold">Time taken</th> -->
                    <th
                        v-for="exam_cover in exam_coverage"
                        class="text-left py-5 font-semibold"
                    >
                        {{ exam_cover.major_name }} Score
                    </th>
                    <th class="text-left py-5 font-semibold">Total</th>
                    <th class="text-left py-5 font-semibold">Status</th>
                    <th class="text-left py-5 font-semibold">Action</th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr
                    v-for="(assessment, index) in assessments"
                    :key="index"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">
                        {{ formatDate(assessment.created_at) }}
                    </td>

                    <td>
                        {{ formatTime(assessment.created_at) }}
                    </td>
                    <!-- looping through the exam coverage -->
                    <td v-for="exam_cover in exam_coverage">
                        <!-- looping through the exams taken -->
                        <span v-for="exam in assessment.exams">
                            <!-- output only if exam_coverage_id equals to exam_taken_id -->
                            <p v-if="exam_cover.id == exam.major_id">
                                {{ exam.exam_answers_count }}/10
                            </p>
                        </span>
                    </td>
                    <td>{{ assessment.total_score }}%</td>
                    <td>
                        <span
                            v-if="assessment.total_score > 75"
                            class="px-3 py-2 bg-green-300 text-green-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >Passed</span
                        >
                        <span
                            v-else
                            class="px-3 py-2 bg-red-300 text-red-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >Failed</span
                        >
                    </td>
                    <!-- <td><RetakeExam :exam="recent_exam" /></td> -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
