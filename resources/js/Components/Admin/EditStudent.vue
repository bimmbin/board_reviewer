<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";

import UpdateStudent from "@/Components/Admin/UpdateStudent.vue";
import DeleteStudent from "@/Components/Admin/DeleteStudent.vue";

const { student } = defineProps({
    student: Object,
});

const show_dialog = ref(false);
const show_delete = ref(false);

const edit = ref("/img/edit.svg");
const delete_icon = ref("/img/delete.svg");
const exit = ref("/img/exit.svg");
</script>

<template>
    <div class="flex items-center gap-2">
        <div
            class="p-2 bg-blue-100 rounded-md select-none cursor-pointer hover:bg-blue-200 active:bg-blue-100"
            @click="show_dialog = !show_dialog"
        >
            <img :src="edit" alt="" />
        </div>
        <div
            class="p-2 bg-red-100 rounded-md select-none cursor-pointer hover:bg-red-200 active:bg-red-100"
            @click="show_delete = !show_delete"
        >
            <img :src="delete_icon" alt="" />
        </div>
    </div>
    <DeleteStudent v-if="show_delete" :student_id="student.id" @close="show_delete = !show_delete"/>
    <UpdateStudent
        v-if="show_dialog"
        :student="student"
        @close_dialog="show_dialog = !show_dialog"
    />
</template>
