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
import CreateStudent from "@/Components/CreateStudent.vue";
import UploadExcel from "@/Components/UploadExcel.vue";
import EditStudent from "@/Components/Admin/EditStudent.vue";
import Flash from "@/Components/Flash.vue";

const { students, major_id, filters } = defineProps({
    students: Object,
    filters: Object,
    major_id: String,
});

let show_details = ref(false);

const search = ref(filters.search);

watch(search, (value) => {
    router.get(
        ("/students/", major_id),
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>

<template>
    <transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="transform opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-700 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="transform opacity-0"
    >
        <Flash
            v-if="$page.props.flash.message"
            :message="$page.props.flash.message"
            :color="$page.props.flash.color"
            :is_array="$page.props.flash.is_array"
            @close_flash="
                ($page.props.flash.message = null),
                    ($page.props.flash.color = null)
            "
        />
    </transition>
    <div
        class="w-full flex items-center justify-between gap-5 max-lg:flex-col max-lg:items-start max-md:gap-2"
    >
        <div
            class="text-3xl font-bold max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl flex items-center"
        >
            Students
        </div>
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
                class="bg-main_bg text-white px-5 py-3 rounded-md select-none cursor-pointer max-md:text-sm max-md:px-3 max-md:py-2 whitespace-nowrap border border-blue-500 max-lg:-translate-x-36 max-md:-translate-x-0"
            >
                <span v-if="!show_details">Create new</span>
                <span v-else>Close</span>
            </div>
        </div>
    </div>
    <Collapse :when="show_details">
        <div
            class="flex max-lg:flex-col gap-10 max-lg:gap-3 bg-blue-100 px-8 max-md:px-5 py-5 mt-5"
        >
            <!-- Create manual form -->
            <CreateStudent
                :major_id="major_id"
                @close_emit="show_details = !show_details"
            />
            <div class="flex lg:flex-col items-center gap-2 opacity-60">
                <span class="text-blue-500 font-medium">or</span>
                <div
                    class="w-fit h-full border-l max-lg:border-t max-lg:w-full max-lg:h-fit border-blue-300"
                ></div>
            </div>
            <!-- Create using excel form -->
            <UploadExcel
                :major_id="major_id"
                @close_it="show_details = !show_details"
            />
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
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-main_bg text-white"
                >
                    <th class="text-left pl-5 py-5 max-md:py-3 font-semibold">
                        Student ID
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
                    v-for="student in students.data"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">{{ student.student_number }}</td>
                    <td>{{ student.last_name }}</td>
                    <td>{{ student.first_name }}</td>
                    <td>{{ student.middle_name }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="">
                                <EditStudent :student="student" />
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="students.links" />
    </div>
</template>
