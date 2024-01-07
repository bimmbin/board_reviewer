<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const { model_id, route_name } = defineProps({
    model_id: String,
    route_name: String,
});

const form = useForm({});
const emit = defineEmits(["close"]);

const submit = () => {
    form.post(route(route_name, model_id), {
        onFinish: () => emit("close"),
    });
};
</script>

<template>
    <div @click="submit()" class="select-none">Yes, Delete</div>
</template>
