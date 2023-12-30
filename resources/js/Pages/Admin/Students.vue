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
    <div class="w-full flex items-center justify-between">
        <div class="flex items-center gap-10" :class="{ 'opacity-20' : show_details }">
            <Link :href="route('students.show', major_id)"
                class="text-3xl font-semibold max-md:mt-20 text-blue-800 max-md:mb-2"
            >
                Students
            </Link>
            <input
                v-model="search"
                type="text"
                placeholder="Search...."
                class="rounded-md border border-blue-300 w-[25rem]"
            />
        </div>
        <div @click="show_details = !show_details" class="bg-blue-500 text-white px-5 py-3 rounded-md select-none cursor-pointer">
            <span v-if="!show_details">Create new</span>
            <span v-else>Close</span>
        </div>
    </div>

    <!-- Create student form -->
    <Collapse :when="show_details">
        <CreateStudent @close_emit="show_details = !show_details"/>
    </Collapse>

    <div class="w-full pb-10 overflow-x-auto mt-5 " :class="{ 'opacity-20' : show_details }">
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px] text-lg xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-blue-500 text-white"
                >
                    <th class="text-left pl-5 py-5 font-semibold">
                        Student ID
                    </th>
                    <th class="text-left py-5 font-semibold">Last Name</th>
                    <th class="text-left py-5 font-semibold">First Name</th>
                    <th class="text-left py-5 font-semibold">Middle Name</th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="student in students.data"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">{{ student.student_id }}</td>
                    <td>{{ student.last_name }}</td>
                    <td>{{ student.first_name }}</td>
                    <td>{{ student.middle_name }}</td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="students.links" />
    </div>
</template>
