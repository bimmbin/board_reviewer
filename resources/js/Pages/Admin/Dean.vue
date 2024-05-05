<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import { Collapse } from "vue-collapsed";

import Pagination from "@/Components/Pagination.vue";
import CreateStaff from "@/Components/Admin/CreateStaff.vue";
import UploadExcel from "@/Components/UploadExcel.vue";
import EditStaff from "@/Components/Admin/EditStaff.vue";

const { instructors, dean_count } = defineProps({
    instructors: Object,
    dean_count: Number,
});

let show_details = ref(false);
</script>

<template>
    <Head title="Dean Account" />

    <div
        class="flex items-center justify-between w-full gap-5 max-lg:flex-col max-lg:items-start max-md:gap-2"
    >
        <div
            class="flex items-center text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl"
        >
            Dean Account
        </div>

        <div
            class="flex items-center justify-between flex-1 w-full gap-10 max-md:gap-3"
        >
            <!-- <input
                v-model="search"
                type="text"
                placeholder="Search...."
                class="rounded-md border border-blue-300 w-[25rem] max-md:text-sm max-md:w-full"
                :class="{ 'opacity-20': show_details }"
            /> -->
            <div class=""></div>
            <div
                v-if="!(dean_count > 1)"
                @click="show_details = !show_details"
                class="px-5 py-3 text-white border border-blue-500 rounded-md cursor-pointer select-none bg-main_bg max-md:text-sm max-md:px-3 max-md:py-2 whitespace-nowrap max-lg:-translate-x-36 max-md:-translate-x-0"
            >
                <span v-if="!show_details">Create dean account</span>
                <span v-else>Close</span>
            </div>
        </div>
    </div>
    <Collapse :when="show_details">
        <div class="flex flex-col items-center gap-10 px-5 mt-5">
            <!-- Create using excel form -->
            <!-- <UploadExcel @close_it="show_details = !show_details" /> -->

            <!-- Create manual form -->
            <div class="flex flex-col items-center px-10 bg-blue-100 w-fit">
                <CreateStaff
                    route_name="dean"
                    @close_emit="show_details = !show_details"
                />
            </div>
        </div>
    </Collapse>

    <div
        class="w-full pb-10 mt-5 overflow-x-auto"
        :class="{ 'opacity-0': show_details }"
    >
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-lg:mr-24 max-md:mr-0 max max-sm:w-[900px] text-lg"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm text-white border border-blue-500 md:text-base lg:text-lg text-start text-btn bg-main_bg"
                >
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Employee ID
                    </th>
                    <th class="py-5 font-semibold text-left max-md:py-3">
                        Last Name
                    </th>
                    <th class="py-5 font-semibold text-left max-md:py-3">
                        First Name
                    </th>
                    <th class="py-5 font-semibold text-left max-md:py-3">
                        Middle Name
                    </th>
                    <th class="py-5 font-semibold text-left max-md:py-3">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="instructor in instructors.data"
                    class="text-sm border border-blue-300 md:text-base lg:text-lg font-regular"
                >
                    <td class="py-3 pl-5">{{ instructor.employee_number }}</td>
                    <td>{{ instructor.last_name }}</td>
                    <td>{{ instructor.first_name }}</td>
                    <td>{{ instructor.middle_name }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="">
                                <EditStaff
                                    :staff="instructor"
                                    route_name="dean"
                                />
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="instructors.links" />
    </div>
</template>
