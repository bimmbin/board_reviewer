<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

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
</script>

<template>
    <div
        class="w-[550px] px-6 py-5 bg-[#3d6ca5] border-t border-l border-r border-blue-200 max-2xl:w-[450px] max-xl:w-full h-52 max-sm:h-40 bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="flex flex-col justify-between w-full h-full">
            <div class="flex items-center justify-between">
                <img :src="lesson_icon" alt="" class="w-12 max-md:w-10" />
                <span
                    v-if="
                        props.category.latest_lesson_length != 0 &&
                        props.category.latest_lesson_length !=
                            props.category.lessons_count
                    "
                    class="px-3 py-2 text-blue-500 bg-white rounded-md max-md:px-2 max-md:py-1 max-md:text-sm"
                    >{{ props.category.latest_lesson_length }}/{{
                        props.category.lessons_count
                    }}</span
                >
                <img
                    v-if="props.category.is_finished"
                    :src="check"
                    alt=""
                    class="w-12 max-md:w-10"
                />
            </div>
            <div class="flex items-center gap-5">
                <h2 class="text-2xl font-light text-white max-md:text-xl">
                    {{ props.category.category_name }}
                </h2>
                <div
                    v-if="props.category.is_finished"
                    class="px-2 py-1 text-xs text-white border border-white rounded-lg w-fit"
                >
                    Finished
                </div>
                <button
                    @click="submit()"
                    class="px-3 py-1 font-medium bg-white rounded text-main_bg whitespace-nowrap"
                >
                    Practice Quiz
                </button>
                <Link
                    :href="route_name"
                    class="px-3 py-1 font-medium bg-white rounded text-main_bg whitespace-nowrap"
                    >Take Lesson</Link
                >
            </div>
        </div>
    </div>
</template>
