<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    major: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    major_id: props.major.id,
});

const submit = () => {
    form.post(route("exam.store"));
};
const lesson_icon = ref("/img/lesson_icon.svg");
</script>

<template>
    <form
        @submit.prevent="submit"
        class="flex-1 border border-blue-200 rounded-md px-10 py-10 bg-[#F4F8FF]"
    >
        <div class="flex flex-col items-center gap-20">
            <h1 class="font-bold text-[3rem]">
                {{ props.major.major_coverage.percent }}%
            </h1>
            <div class="flex flex-col items-center">
                <h2
                    class="px-5 border-b border-blue-200 text-center w-fit font-medium text-3xl"
                >
                    {{ props.major.major_name }}
                </h2>
                <span class="font-light opacity-80">Title</span>
            </div>
            <div class="flex flex-col items-center">
                <h2
                    class="px-5 border-b border-blue-200 text-center w-fit font-medium text-2xl"
                >
                    150
                </h2>
                <span class="font-light opacity-80">Items</span>
            </div>
            <button
                class="w-full bg-main_bg rounded-md text-white py-3 px-5 font-medium hover:bg-blue-400"
            >
                Take Exam
            </button>
        </div>
    </form>
</template>
