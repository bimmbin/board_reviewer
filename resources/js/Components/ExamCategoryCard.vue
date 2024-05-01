<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";

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

const lock_info = () => {
    Swal.fire({
        title: "Locked",
        text: "Please make sure to finish all the practice quizzes first.",
        icon: "info",
    });
};
</script>

<template>
    <form
        v-if="!$props.major.has_taken"
        @submit.prevent="submit"
        class="flex-1 border border-blue-200 rounded-md px-10 py-10 bg-[#F4F8FF]"
    >
        <div class="flex flex-col items-center gap-20">
            <h1 class="font-bold text-[3rem]">
                {{ props.major.major_coverage[0].percent }}%
            </h1>
            <div class="flex flex-col items-center">
                <h2
                    class="px-5 text-3xl font-medium text-center border-b border-blue-200 w-fit"
                >
                    {{ props.major.major_name }}
                </h2>
                <span class="font-light opacity-80">Title</span>
            </div>
            <div class="flex flex-col items-center">
                <h2
                    class="px-5 text-2xl font-medium text-center border-b border-blue-200 w-fit"
                >
                    150
                </h2>
                <span class="font-light opacity-80">Items</span>
            </div>
            <button
                v-if="props.major.is_unlocked"
                class="flex items-center justify-center w-full gap-2 px-5 py-3 font-medium text-white rounded-md bg-main_bg hover:bg-blue-400"
            >
                Take Exam
            </button>
            <div
                v-else
                @click="lock_info()"
                class="flex items-center justify-center w-full gap-2 px-5 py-3 font-medium text-white rounded-md bg-main_bg hover:bg-blue-400"
            >
                <img src="/img/lock.svg" alt="" />
            </div>
        </div>
    </form>
</template>
