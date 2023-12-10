<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    category_id: props.category.id,
});

const submit = () => {
    form.post(route("exam.store"));
};
const lesson_icon = ref("/img/lesson_icon.svg");
</script>

<template>
    <form @submit.prevent="submit"
        class="w-[550px] px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-400 max-2xl:w-[450px] max-xl:w-full h-52 max-sm:h-40 bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="w-full h-full flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <h2 class="text-white text-2xl font-light max-md:text-xl">
                    {{ props.category.category_name }}
                </h2>
                <span
                    class=" px-3 py-2 max-md:px-2 max-md:py-1 rounded-md text-white max-md:text-sm"
                    >{{ props.category.lessons_count }} Items</span
                >
            </div>
            <div class="flex items-center">
              <button class="bg-white px-3 py-2 max-md:px-2 max-md:py-1 rounded-md text-blue-700 max-md:text-sm">Take exam</button>
            </div>
        </div>
      </form>
</template>
