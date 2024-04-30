<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link, useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const { exam, lessons, correct_count, lesson_count, category_name } =
    defineProps({
        exam: Object,
        lessons: Object,
        correct_count: Number,
        lesson_count: Number,
        category_name: String,
    });
const trophy = ref("/img/trophy.png");
const exit = ref("/img/exit.svg");

const form = useForm({
    major_id: exam.major.id,
});

const submit = () => {
    form.post(route("exam.store"));
};
</script>

<template>
    <Head title="Exam Final Result" />

    <div class="flex justify-center w-full min-h-screen md:-mt-8">
        <div
            class="w-[800px] max-xl:w-full my-10 max-sm:mb-20 max-md:mt-20 flex flex-col justify-between relative"
        >
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center">
                        <Link :href="route('category.index')" class="px-1 py-1"
                            ><img :src="exit" class="h-4 max-md:h-3"
                        /></Link>
                        <h1
                            class="px-3 py-2 text-lg font-semibold text-gray-500 rounded-md max-md:text-sm max-md:px-1"
                        >
                            Back to lessons
                        </h1>
                    </div>
                    <div class=""></div>
                </div>
                <div class="flex items-center gap-5 px-5 py-8">
                    <div class="flex items-center justify-center">
                        <img :src="trophy" class="w-20 max-md:w-14" />
                    </div>
                    <div
                        class="flex flex-col items-center gap-5 px-10 text-center"
                    >
                        <p class="text-lg max-md:text-base">
                            You have successfully completed a practice quiz on
                            the subject of
                            <span class="font-medium text-blue-700">{{
                                category_name
                            }}</span>
                            major in
                            <span class="font-medium text-blue-700">{{
                                exam.major.major_name
                            }}</span>
                        </p>
                    </div>
                    <div
                        class="flex items-center justify-center px-5 py-3 text-2xl text-center text-blue-700 bg-blue-200 rounded-md w-fit max-md:text-base max-md:px-4"
                    >
                        {{ correct_count }}/{{ lesson_count }}
                    </div>
                </div>
            </div>
            <div class="flex text-sm font-light">
                <h2 class="flex-1 px-3 py-1 text-center">Questions</h2>
                <div class="flex w-80">
                    <div
                        class="flex items-center justify-center flex-1 px-3 py-1 text-center"
                    >
                        Answer
                    </div>
                    <div
                        class="flex items-center justify-center flex-1 px-3 py-1 text-center"
                    >
                        Your Answer
                    </div>
                </div>
            </div>
            <div
                class="w-full flex flex-col border-x border-t border-blue-200 bg-[#F4F8FF] text-sm"
            >
                <div
                    v-for="lesson in lessons"
                    class="flex border-b border-blue-200"
                >
                    <h2
                        class="flex-1 px-3 py-4 text-center border-r border-blue-200"
                    >
                        {{ lesson.lesson_question }}
                    </h2>
                    <div class="flex w-80">
                        <div
                            class="flex items-center justify-center flex-1 px-3 py-3 text-center text-green-600"
                        >
                            {{ lesson.correct_answer }}
                        </div>
                        <div
                            class="flex items-center justify-center flex-1 px-3 py-3 text-center border-l border-blue-200"
                            :class="{
                                'text-green-600':
                                    lesson.correct_answer == lesson.exam_answer,
                            }"
                        >
                            {{ lesson.exam_answer }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- <form
                @submit.prevent="submit"
                class="flex justify-between w-full max-md:fixed max-md:bottom-16 max-md:px-5 max-md:left-0"
            >
                <Link
                    :href="route('exam.index')"
                    class="px-5 py-2 font-semibold text-blue-500 border-2 border-blue-500 rounded-md"
                >
                    Back to exams
                </Link>

                <button
                    class="px-5 py-2 font-semibold text-white border-2 border-blue-500 rounded-md select-none bg-main_bg"
                >
                    Retake
                </button>
            </form> -->
        </div>
    </div>
</template>
