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

const { instructors, filters } = defineProps({
    instructors: Object,
    filters: Object,
});

let show_details = ref(false);

const search = ref(filters.search);

watch(search, (value) => {
    router.get(
        ("/instructors"),
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>

<template>
    <div
        class="w-full flex items-center justify-between gap-5 max-lg:flex-col max-lg:items-start max-md:gap-2"
    >
        <Link
            :href="route('instructors.index')"
            class="text-3xl font-semibold max-md:mt-20 text-blue-800 max-md:mb-2 max-md:text-2xl"
            :class="{ 'opacity-20': show_details }"
        >
            Instructors
        </Link>
        <div
            class="w-full flex-1 flex items-center justify-between gap-10 max-md:gap-3"
        >
            <input
                v-model="search"
                type="text"
                placeholder="Search...."
                class="rounded-md border border-blue-300 w-[25rem] max-md:text-sm max-md:w-full"
                :class="{ 'opacity-20': show_details }"
            />
            <div
                @click="show_details = !show_details"
                class="bg-blue-500 text-white px-5 py-3 rounded-md select-none cursor-pointer max-md:text-sm max-md:px-3 max-md:py-2 whitespace-nowrap border border-blue-500 max-lg:-translate-x-36 max-md:-translate-x-0"
            >
                <span v-if="!show_details">Create new</span>
                <span v-else>Close</span>
            </div>
        </div>
    </div>
    <Collapse :when="show_details">
        <div class="flex flex-col gap-10 bg-blue-100 px-5 mt-5">
            <!-- Create using excel form -->
            <!-- <UploadExcel @close_it="show_details = !show_details" /> -->
       
            <!-- Create manual form -->
            <CreateStaff route_name="instructors" @close_emit="show_details = !show_details" />
        </div>
    </Collapse>

    <div
        class="w-full pb-10 overflow-x-auto mt-5"
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
                        Employee ID
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Last Name
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        First Name
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Middle Name
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="instructor in instructors.data"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">{{ instructor.employee_number }}</td>
                    <td>{{ instructor.last_name }}</td>
                    <td>{{ instructor.first_name }}</td>
                    <td>{{ instructor.middle_name }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="">
                                <EditStaff :staff="instructor" route_name="instructors" />
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="instructors.links" />
    </div>
</template>
