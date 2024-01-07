<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import SureDialog from "@/Components/SureDialog.vue";
import ElementDetails from "@/Components/ElementDetails.vue";
import Delete from "@/Components/Delete.vue";

const emit = defineEmits(["close_dialog"]);

const { lesson_id } = defineProps({
    lesson_id: String,
});

const cancel = ref("/img/cancel.svg");

const show_dialog = ref(false);
</script>

<template>
    <ElementDetails details="Cancel lesson">
        <div
            @click="show_dialog = !show_dialog"
            class="p-2 bg-gray-100 rounded-md select-none cursor-pointer hover:bg-blue-200 active:bg-blue-100"
        >
            <img :src="cancel" alt="" class="h-5" />
        </div>
    </ElementDetails>
    <SureDialog
        v-if="show_dialog"
        title="Are you sure you want to cancel this lesson?"
        warning="Cancelling this action will permanently delete the data from the database, and there is no way to recover it."
        width="40"
    >
        <Delete
            route_name="instructor.lessons.destroy"
            :model_id="lesson_id"
            @close="show_dialog = !show_dialog"
            class="text-white bg-red-700 px-5 py-1 rounded-md"
        />
        <div
            @click="show_dialog = false"
            class="bg-gray-300 px-5 py-1 rounded-md"
        >
            Cancel
        </div>
    </SureDialog>
</template>
