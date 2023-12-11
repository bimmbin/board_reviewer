<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const {
    lesson,
    exam_answer,
    current_page,
    lessons_count,
    category_id,
    exam_id,
} = defineProps({
    lesson: Object,
    exam_answer: Object,
    current_page: String,
    lessons_count: Number,
    category_id: Number,
    exam_id: String,
});
const exit = ref("/img/exit.svg");
</script>

<template>
    <div class="w-full h-screen flex justify-center max-md:mt-6">
        <div
            class="w-[800px] max-xl:w-full my-10 mb-60 max-sm:mb-20 max-md:mt-20 flex flex-col justify-between relative"
        >
            <div class="flex flex-col gap-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <Link :href="route('category.index')" class="px-1 py-1"
                            ><img :src="exit" class="h-4 max-md:h-3"
                        /></Link>
                        <h1
                            class="px-3 py-2 rounded-md text-lg font-semibold text-gray-500 max-md:text-sm max-md:px-1"
                        >
                            {{ lesson.category.category_name }}
                        </h1>
                    </div>
                    <span
                        class="w-fit h-fit px-3 py-3 bg-blue-200 rounded-md text-blue-500 max-md:text-sm max-md:py-2 max-md:px-2"
                        >{{ current_page }}/{{ lessons_count }}</span
                    >
                </div>
                <div class="flex flex-col items-center gap-10 mt-10">
                    <p class="text-center text-xl max-md:text-base">
                        {{ lesson.lesson_question }}
                    </p>
                    <span
                        v-if="exam_answer.is_correct == 1"
                        class="text-4xl font-medium text-green-500"
                        >Correct!</span
                    >
                    <span v-else class="text-4xl font-medium text-red-500"
                        >Wrong!</span
                    >
                    <div class="flex flex-col w-full gap-2 items-center">
                        <div
                            v-if="exam_answer.is_correct == 0"
                            class="flex flex-col items-center gap-2"
                        >
                            <span>Your answer</span>
                            <span
                                class="capitalize w-fit px-5 py-2 text-center bg-red-200 border border-red-200 rounded-md cursor-pointer"
                            >
                                {{ exam_answer.choice.choice_description }}
                            </span>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <span>Correct answer</span>
                            <span
                                class="capitalize w-fit px-5 py-2 border-2 border-green-500 bg-green-200 rounded-md cursor-pointer"
                            >
                                {{
                                    lesson.correct_answer.choice
                                        .choice_description
                                }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="max-md:fixed max-md:bottom-16 max-md:px-5 max-md:left-0 w-full flex justify-between"
            >
                <div v-if="current_page != 1">
                    <!-- <Link
                        :href="
                            route('exam.result.show', [
                                exam_id,
                                category_id,
                                parseInt(current_page) - 1,
                            ])
                        "
                        class="py-2 px-5 border-2 border-blue-500 rounded-md text-blue-500 font-semibold"
                    >
                        Back
                    </Link> -->
                </div>
                <div v-else></div>

                <div v-if="current_page == lessons_count">
                    <Link
                        :href="route('category.index')"
                        class="py-2 px-5 border-2 border-blue-500 rounded-md bg-blue-500 text-white font-semibold"
                    >
                        Finish
                    </Link>
                </div>
                <div v-else>
                    <Link
                        :href="
                            route('exam.show', [
                                exam_id,
                                category_id,
                                parseInt(current_page) + 1,
                            ])
                        "
                        class="py-2 px-5 border-2 border-blue-500 rounded-md bg-blue-500 text-white font-semibold"
                    >
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
