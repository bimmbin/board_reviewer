<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import SureDialog from "@/Components/SureDialog.vue";

const { user_id } = defineProps({
    user_id: String,
});

const form = useForm({});
const emit = defineEmits(["close"]);

const submit = () => {
    form.post(route("students.destroy", user_id), {
        onFinish: () => emit("close"),
    });
};
</script>

<template>
    <SureDialog title="Are you sure you want to delete this user?">
        <div
            @click="submit()"
            class="text-white bg-red-700 px-5 py-1 rounded-md"
        >
            Yes
        </div>
        <div
            @click="$emit('close')"
            class="px-5 py-1 bg-gray-300 rounded-md"
        >
            No
        </div>
    </SureDialog>
</template>
