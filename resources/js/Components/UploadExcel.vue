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
        class="bg-white border border-blue-100 px-5 py-3 max-md:px-3 max-md:py-2 max-md:text-sm flex items-center justify-between mt-5 max-md:flex-col max-md:items-start max-md:gap-3"
    >
        <div class="flex items-center gap-5">
            <label for="file" class="bg-main_bg px-3 py-2 whitespace-nowrap text-white">
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
        <button class="bg-blue-200 text-white px-3 py-2 rounded-md max-md:w-full" :disabled="form.file.length == 0" :class="{'bg-main_bg' : form.file.length != 0}">
            submit
        </button>
    </form>
  </div>
</template>
