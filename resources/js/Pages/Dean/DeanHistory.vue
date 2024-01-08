<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";

const { histories } = defineProps({
    histories: Object,
});
</script>

<template>
    <div
        class="w-full flex items-center justify-between gap-5 max-lg:flex-col max-lg:items-start max-md:gap-2 mt-2"
    >
        <h1
            class="text-3xl font-semibold max-md:mt-20 text-blue-800 max-md:mb-2 max-md:text-2xl capitalize"
        >
            History
        </h1>
    </div>

    <div class="w-full pb-10 overflow-x-auto mt-5 max-md:mt-2">
        <table
            id="dataTable"
            class="table-auto text-center w-[1000px] max-lg:w-[800px] max-lg:mr-24 max-md:mr-0 max max-sm:w-[600px] text-lg"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-blue-500 text-white"
                >
                    <th class="text-left pl-5 py-5 max-md:py-3 font-semibold">
                        History Content
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Uploaded by
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="history in histories.data"
                    :key="index"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3 normal-case">
                      <span class="capitalize">{{ history.status }} </span>
                        {{
                            history.category_name +
                            " in the " +
                            history.major_name +
                            " major on " +
                            history.date
                        }}
                    </td>
                    <td>{{ history.uploaded_by }}</td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="histories.links" />
    </div>
</template>
