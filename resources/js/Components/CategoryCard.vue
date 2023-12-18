<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    category: {
        type: Object,
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
console.log(route_name);
const lesson_icon = ref("/img/lesson_icon.svg");
const check = ref("/img/check.svg");
</script>

<template>
    <Link
        :href="route_name"
        class="w-[550px] px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-400 max-2xl:w-[450px] max-xl:w-full h-52 max-sm:h-40 bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="w-full h-full flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <img :src="lesson_icon" alt="" class="w-12 max-md:w-10" />
                <span
                    v-if="
                        props.category.latest_lesson_length != 0 &&
                        props.category.latest_lesson_length !=
                            props.category.lessons_count
                    "
                    class="bg-white px-3 py-2 max-md:px-2 max-md:py-1 rounded-md text-blue-500 max-md:text-sm"
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
            <div class="flex items-center">
                <h2 class="text-white text-2xl font-light max-md:text-xl">
                    {{ props.category.category_name }}
                </h2>
            </div>
        </div>
    </Link>
</template>
