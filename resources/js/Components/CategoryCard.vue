<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
    major_id: {
        type: Number,
        required: true,
    },
});
let page_number = ref();
let route_name = ref();
if (
    props.category.latest_lesson_length == 0 ||
    props.category.latest_lesson_length == props.category.lessons_count ||
    props.category.recent_time_ended == 1
) {
    page_number = 1;
    route_name = route("lesson.store", [props.category.id, page_number]);
} else {
    page_number = props.category.latest_lesson_length + 1;
    route_name = route("lesson.index", [
        props.category.recent_lesson_id,
        props.category.id,
        page_number,
    ]);
}

const lesson_icon = ref("/img/lesson_icon.svg");
const check = ref("/img/check.svg");

const form = useForm({
    major_id: props.major_id,
    category_id: props.category.id,
});

const submit = () => {
    form.post(route("quiz.store"));
};
const baseUrl = window.location.origin + "/storage/" + props.category.pdf;

const no_pdf = () => {
    Swal.fire({
        title: "This lesson has no PDF uploaded",
        icon: "error",
    });
};
</script>

<template>
    <div
        class="w-fit px-6 py-5 bg-[#3d6ca5] border-t border-l border-r border-blue-200 max-2xl:w-[450px] bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="flex flex-col justify-between h-full gap-5">
            <div class="flex justify-between w-full gap-5">
                <div class="flex items-center w-full gap-5">
                    <h2 class="text-2xl font-medium text-white max-md:text-xl">
                        {{ props.category.category_name }}
                    </h2>
                    <div
                        v-if="props.category.finished_quizzes_count != 0"
                        class="px-2 py-1 text-xs text-white border border-white rounded-lg w-fit"
                    >
                        Finished
                    </div>
                </div>
                <div class="flex justify-end w-20">
                    <img :src="lesson_icon" alt="" class="w-12 max-md:w-10" />
                </div>
            </div>

            <div
                class="w-[560px] h-[315px] bg-gray-300 flex items-center justify-center"
                v-if="!props.category.embed"
            >
                No Embedded Video
            </div>
            <div v-else v-html="props.category.embed"></div>
            <div class="flex items-center justify-between">
                <img
                    v-if="props.category.finished_quizzes_count != 0"
                    :src="check"
                    alt=""
                    class="w-12 max-md:w-10"
                />
                <div class="flex gap-5">
                    <a
                        v-if="props.category.pdf"
                        :href="baseUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="px-3 py-1 font-medium bg-white rounded text-main_bg whitespace-nowrap"
                        >View Lesson
                    </a>
                    <div
                        v-else
                        @click="no_pdf()"
                        class="px-3 py-1 font-medium bg-white rounded cursor-pointer text-main_bg whitespace-nowrap"
                    >
                        View Lesson
                    </div>
                    <button
                        @click="submit()"
                        class="px-3 py-1 font-medium bg-white rounded text-main_bg whitespace-nowrap"
                    >
                        Practice Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
