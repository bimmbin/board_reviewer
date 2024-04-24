<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref, watch } from "vue";
import { router, Head } from "@inertiajs/vue3";

import { format } from "date-fns";

const { assessments, filters } = defineProps({
    assessments: Object,
    filters: Object,
});

const formatDate = (dateString) => {
    return format(new Date(dateString), "MMMM dd, yyyy"); // Customize the format as needed
};
const formatTime = (dateString) => {
    return format(new Date(dateString), "hh:mm a"); // Customize the format as needed
};

const search = ref(filters.search);
const sort = ref(filters.sort);

watch([search, sort], ([searchValue, sortValue]) => {
    router.get(
        "/history/assessments/",
        { search: searchValue, sort: sortValue },
        { preserveState: false, replace: true }
    );
});
</script>

<template>
    <Head title="Assessments" />
    <div class="flex items-center gap-5 mb-3">
        <div
            class="flex items-center text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl"
        >
            Assessments
        </div>
        <input
            v-model="search"
            type="text"
            placeholder="Search...."
            class="rounded-md text-sm border border-blue-300 w-[25rem] max-md:text-sm max-md:w-full"
        />
        <select
            v-model="sort"
            class="text-sm border border-blue-300 rounded-md"
        >
            <option value="1" selected>Latest</option>
            <option value="2">Highest to Lowest</option>
            <option value="3">Lowest to Highest</option>
        </select>
    </div>

    <div class="w-full pb-10 overflow-x-auto">
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px] xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm text-white border border-blue-500 md:text-base text-start text-btn bg-main_bg"
                >
                    <th class="py-5 pl-5 font-semibold text-left">Name</th>
                    <th class="py-5 pl-5 font-semibold text-left">Major</th>
                    <th class="py-5 pl-5 font-semibold text-left">Date</th>
                    <th class="pl-5 font-semibold text-left">Time</th>
                    <!-- <th class="py-5 font-semibold text-left">Time taken</th> -->
                    <th class="pl-5 font-semibold text-left">Score</th>
                    <th class="pl-5 font-semibold text-left">Score</th>
                    <th class="pl-5 font-semibold text-left">Total</th>
                    <th class="pl-5 font-semibold text-left">Status</th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr
                    v-for="(assessment, index) in assessments"
                    :key="index"
                    class="text-sm border border-blue-300 font-regular whitespace-nowrap"
                >
                    <td class="py-4 pl-5 max-md:px-5">
                        {{ assessment.first_name }} {{ assessment.last_name }}
                    </td>

                    <td class="py-3 pl-5 max-md:px-5">
                        {{ assessment.major }}
                    </td>

                    <td class="py-3 pl-5 max-md:px-5">
                        {{ formatDate(assessment.updated_at) }}
                    </td>

                    <td class="py-3 pl-5 max-md:px-5">
                        {{ formatTime(assessment.updated_at) }}
                    </td>
                    <!-- If exam isnt finished yet -->
                    <td
                        v-if="assessment.exam_scores.length == 1"
                        class="py-3 pl-5 max-md:px-5"
                    ></td>
                    <!-- looping through the exam coverage -->
                    <td
                        class="py-3 pl-5 max-md:px-5"
                        v-for="exam_cover in assessment.exam_scores"
                    >
                        {{ exam_cover }}
                    </td>
                    <td class="py-3 pl-5 max-md:px-5">
                        {{ assessment.total_score }}%
                    </td>
                    <td class="pl-5 max-md:px-5">
                        <span
                            v-if="assessment.total_score >= 75"
                            class="px-3 py-2 text-sm text-green-800 bg-green-300 rounded-md max-md:text-xs max-md:py-1"
                            >Passed</span
                        >
                        <span
                            v-else
                            class="px-3 py-2 text-sm text-red-800 bg-red-300 rounded-md max-md:text-xs max-md:py-1"
                            >Failed</span
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
