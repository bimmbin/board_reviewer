<script setup>
import { useForm } from "@inertiajs/vue3";

const { exam } = defineProps({
    exam: Object,
});
const form = useForm({
    category_id: exam.category_id,
});

const submit = () => {
    form.post(route("exam.store"));
};
</script>

<template>
    <form @submit.prevent="submit">
      <button class="underline text-base max-md:text-sm">Retake</button>
    </form>
</template>
