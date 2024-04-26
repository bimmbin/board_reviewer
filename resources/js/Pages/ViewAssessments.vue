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
const start_date = ref(filters.start_date);
const end_date = ref(filters.end_date);

const submit = () => {
    router.get(
        "/history/assessments/",
        {
            search: search.value,
            sort: sort.value,
            start_date: start_date.value,
            end_date: end_date.value,
        },
        { preserveState: false, replace: true }
    );
};
</script>

<template>
    <Head title="Assessments" />
    <div class="flex items-end justify-between mb-3">
        <div
            class="flex items-center text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl"
        >
            Assessments
        </div>
        <div class="flex items-center gap-5 text-sm">
            <div class="flex items-end gap-2">
                <div class="flex flex-col">
                    <label for="search" class="text-xs font-medium select-none"
                        >Search</label
                    >
                    <input
                        id="search"
                        v-model="search"
                        type="text"
                        placeholder="Search by name or student number"
                        class="rounded-md text-sm border border-blue-300 w-[18rem] max-md:text-sm max-md:w-full"
                    />
                </div>
                <div class="flex flex-col">
                    <label for="sort" class="text-xs font-medium select-none"
                        >Sort</label
                    >
                    <select
                        id="sort"
                        v-model="sort"
                        class="text-sm border border-blue-300 rounded-md"
                    >
                        <option value="1" selected>Latest</option>
                        <option value="2">Highest to Lowest</option>
                        <option value="3">Lowest to Highest</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label
                        for="start_date"
                        class="text-xs font-medium select-none"
                        >Start Date</label
                    >
                    <input
                        v-model="start_date"
                        id="start_date"
                        type="date"
                        class="text-sm border border-blue-300 rounded-md"
                    />
                </div>
                <div class="flex flex-col">
                    <label
                        for="end_date"
                        class="text-xs font-medium select-none"
                        >End Date</label
                    >
                    <input
                        v-model="end_date"
                        id="end_date"
                        type="date"
                        class="text-sm border border-blue-300 rounded-md"
                    />
                </div>
                <button
                    @click="submit()"
                    class="px-5 py-2 text-sm text-white border rounded-md border-main_bg bg-main_bg whitespace-nowrap"
                >
                    Apply Filter
                </button>
            </div>
        </div>
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
                    v-for="assessment in assessments"
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
