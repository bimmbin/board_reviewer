<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import TableTemplate from "@/Components/TableTemplate.vue";

const { students } = defineProps({
    students: Object,
});
</script>

<template>
    <h1
        class="text-3xl font-semibold mb-5 max-md:mt-20 text-blue-800 max-md:mb-2"
    >
        Students
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
                    <th class="text-left pl-5 py-5 font-semibold">Student ID</th>
                    <th class="text-left py-5 font-semibold">Last Name</th>
                    <th class="text-left py-5 font-semibold">First Name</th>
                    <th class="text-left py-5 font-semibold">Middle Name</th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr v-for="student in students"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">{{ student.student_id }}</td>
                    <td>{{ student.last_name }}</td>
                    <td>{{ student.first_name }}</td>
                    <td>{{ student.middle_name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
