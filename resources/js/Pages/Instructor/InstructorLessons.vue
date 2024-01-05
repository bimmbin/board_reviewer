<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref, watch } from "vue";
import { router, Link } from "@inertiajs/vue3";
import { Collapse } from "vue-collapsed";

import Pagination from "@/Components/Pagination.vue";
import CreateStaff from "@/Components/Admin/CreateStaff.vue";
import UploadExcel from "@/Components/UploadExcel.vue";
import EditStaff from "@/Components/Admin/EditStaff.vue";

const { lessons, status } = defineProps({
    lessons: Object,
    status: String,
});

let show_details = ref(false);
</script>

<template>
    <div
        class="w-full flex items-center justify-between gap-5 max-lg:flex-col max-lg:items-start max-md:gap-2 mt-2"
    >
        <h1
            class="text-3xl font-semibold max-md:mt-20 text-blue-800 max-md:mb-2 max-md:text-2xl capitalize"
        >
            {{ status }} lessons
        </h1>
    </div>

    <div
        class="w-full pb-10 overflow-x-auto mt-5 max-md:mt-2"
        :class="{ 'opacity-0': show_details }"
    >
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-lg:mr-24 max-md:mr-0 max max-sm:w-[900px] text-lg"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-blue-500 text-white"
                >
                    <th class="text-left pl-5 py-5 max-md:py-3 font-semibold">
                        No.
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Lesson Name
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Items
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Status
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Uploaded by
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="(lesson, index) in lessons.data"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">{{ index + 1 }}</td>
                    <td>{{ lesson.category_name }}</td>
                    <td>{{ lesson.item_count }}</td>
                    <td>
                        <span
                            class="px-3 py-2 bg-yellow-300 text-yellow-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >{{ lesson.status }}</span
                        >
                    </td>
                    <td>{{ lesson.uploaded_by }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="">
                                <!-- <EditStaff :staff="instructor" route_name="lessons" /> -->
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="lessons.links" />
    </div>
</template>