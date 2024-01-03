<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";

import DeleteUser from "@/Components/Admin/DeleteUser.vue";
import UpdateStaff from "@/Components/Admin/UpdateStaff.vue";

const { staff } = defineProps({
    staff: Object,
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
    <DeleteUser v-if="show_delete" :user_id="staff.user_id" @close="show_delete = !show_delete"/>
    <UpdateStaff
        v-if="show_dialog"
        :staff="staff"
        @close_dialog="show_dialog = !show_dialog"
    />
</template>
