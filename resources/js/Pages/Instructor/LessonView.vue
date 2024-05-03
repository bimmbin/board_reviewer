<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const { lesson, current_page, lessons_count, category_id, recent_id } =
    defineProps({
        lesson: Object,
        current_page: String,
        lessons_count: Number,
        category_id: String,
    });

const exit = ref("/img/exit.svg");
</script>

<template>
    <Head :title="lesson.category.category_name" />
    <div class="flex justify-center w-full h-screen max-md:mt-6">
        <div
            class="w-[800px] max-xl:w-full my-10 mb-60 max-sm:mb-20 max-md:mt-20 flex flex-col justify-between relative"
        >
            <div class="flex flex-col gap-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <Link
                            :href="route('instructor.majors.index')"
                            class="px-1 py-1"
                            ><img :src="exit" class="h-4 max-md:h-3"
                        /></Link>
                        <h1
                            class="px-3 py-2 text-lg font-semibold text-gray-500 rounded-md max-md:text-sm max-md:px-1"
                        >
                            {{ lesson.category.category_name }}
                        </h1>
                    </div>
                    <span
                        class="px-3 py-3 text-blue-500 bg-blue-200 rounded-md w-fit h-fit max-md:text-sm max-md:py-2 max-md:px-2"
                        >{{ current_page }}/{{ lessons_count }}</span
                    >
                </div>
                <div class="flex flex-col items-center gap-10 mt-10">
                    <p class="text-xl text-center max-md:text-base">
                        {{ lesson.lesson_question }}
                    </p>

                    <div class="flex flex-col w-full gap-2">
                        <div
                            v-for="choice in lesson.choices"
                            class="flex w-full"
                        >
                            <span
                                class="w-full px-5 py-2 border border-blue-200 rounded-md cursor-pointer max-md:text-sm hover:bg-blue-200"
                                :class="{
                                    'bg-green-200 text-green-800':
                                        lesson.correct_answer.choice_id ==
                                        choice.id,
                                }"
                                >{{ choice.choice_description }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="flex justify-between w-full max-md:fixed max-md:bottom-16 max-md:px-5 max-md:left-0"
            >
                <div v-if="current_page == 1">
                    <Link
                        :href="route('instructor.majors.index')"
                        class="px-5 py-2 font-semibold text-blue-500 border-2 border-blue-500 rounded-md"
                    >
                        Back to lists of majors
                    </Link>
                </div>
                <div v-else>
                    <Link
                        :href="
                            route('instructor.lessons.show', [
                                category_id,
                                parseInt(current_page) - 1,
                            ])
                        "
                        class="px-5 py-2 font-semibold text-blue-500 border-2 border-blue-500 rounded-md"
                    >
                        Back
                    </Link>
                </div>

                <div v-if="current_page == lessons_count">
                    <Link
                        :href="route('instructor.majors.index')"
                        class="px-5 py-2 font-semibold text-white border-2 border-blue-500 rounded-md bg-main_bg"
                    >
                        Finish
                    </Link>
                </div>
                <div v-else>
                    <Link
                        :href="
                            route('instructor.lessons.show', [
                                category_id,
                                parseInt(current_page) + 1,
                            ])
                        "
                        class="px-5 py-2 font-semibold text-white border-2 border-blue-500 rounded-md bg-main_bg"
                    >
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
