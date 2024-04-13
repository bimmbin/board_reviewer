<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    student: {
        type: Object,
    },
    instructor: {
        type: Object,
    },
    dean: {
        type: Object,
    },
    admin: {
        type: Object,
    },
});
</script>

<template>
    <div class="flex items-center justify-center w-screen h-screen">
        <div class="flex flex-col flex-wrap gap-3">
            <span class="font-semibold">For testing purposes</span>
            <div class="flex flex-col flex-1 border-t border-blue-300">
                <span class="font-semibold">Student</span>
                <span>Username: {{ student.username }}</span>
                <span
                    >Password:
                    {{ student.student_profile.student_number }}</span
                >
            </div>

            <div class="flex flex-col border-t border-blue-300">
                <span class="font-semibold">Instructor</span>
                <span>Username: {{ instructor.username }}</span>
                <span
                    >Password:
                    {{ instructor.staff_profile.employee_number }}</span
                >
            </div>

            <div class="flex flex-col border-t border-blue-300">
                <span class="font-semibold">Dean</span>
                <span>Username: {{ dean.username }}</span>
                <span>Password: {{ dean.staff_profile.employee_number }}</span>
            </div>

            <div class="flex flex-col border-t border-blue-300">
                <span class="font-semibold">Admin</span>
                <span>Username: {{ admin.username }}</span>
                <span>Password: admin123</span>
            </div>
        </div>
    </div>

    <Head title="Log in Credentials" />
</template>
