<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const emit = defineEmits(["close_it"]);

const form = useForm({
    file: [],
});

const submit = () => {
  form.post(route("students.store.excel"), {
        onFinish: () => emit("close_it"),
    });
};
</script>

<template>
  <div class="">
  <h1 class="text-xl font-semibold text-blue-800 max-md:mb-2 pt-5">
        Using excel
    </h1>
    <form
        @submit.prevent="submit"
        class="bg-white border border-blue-100 px-5 py-3 flex items-center justify-between mt-5"
    >
        <div class="flex items-center gap-5">
            <label for="file" class="bg-blue-500 px-3 py-2 text-white">
                <input
                    type="file"
                    id="file"
                    @input="form.file = $event.target.files[0]"
                    accept=".xlsx, .xls"
                    class="hidden"
                />
                Choose file
            </label>
            <span>{{
                form.file.length != 0 ? form.file.name : "No file chosen"
            }}</span>
        </div>
        <button class="bg-blue-200 text-white px-3 py-2 rounded-md" :disabled="form.file.length == 0" :class="{'bg-blue-500' : form.file.length != 0}">
            submit
        </button>
    </form>
  </div>
</template>
