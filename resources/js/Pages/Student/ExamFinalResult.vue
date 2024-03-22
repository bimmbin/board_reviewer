<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link, useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

const { exam, lessons, correct_count, lesson_count } = defineProps({
    exam: Object,
    lessons: Object,
    correct_count: Number,
    lesson_count: Number,
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

    <div class="w-full min-h-screen flex justify-center md:-mt-8">
        <div
            class="w-[800px] max-xl:w-full my-10 max-sm:mb-20 max-md:mt-20 flex flex-col justify-between relative"
        >
            <div class="flex flex-col items-center">
                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center">
                        <Link :href="route('exam.index')" class="px-1 py-1"
                            ><img :src="exit" class="h-4 max-md:h-3"
                        /></Link>
                        <h1
                            class="px-3 py-2 rounded-md text-lg font-semibold text-gray-500 max-md:text-sm max-md:px-1"
                        >
                            Back to exams
                        </h1>
                    </div>
                    <div class=""></div>
                </div>
                <div class="flex items-center py-8 px-5 gap-5">
                    <div class="flex items-center justify-center">
                        <img :src="trophy" class="w-20 max-md:w-14" />
                    </div>
                    <div class="flex flex-col items-center text-center gap-5">
                        <h2 class="text-3xl font-medium max-md:text-2xl">
                            Congratulations!
                        </h2>
                        <p class="text-lg max-md:text-base">
                            You have successfully completed an exam on
                            <span class="font-medium text-blue-700">{{
                                exam.major.major_name
                            }}</span>
                        </p>
                    </div>
                    <div
                        class="text-2xl px-5 py-3 w-fit bg-blue-200 rounded-md text-blue-700 max-md:text-base max-md:px-4 flex items-center justify-center text-center"
                    >
                        {{ correct_count }}/{{ lesson_count }}
                    </div>
                </div>
            </div>
            <div class="flex text-sm font-light">
                <h2 class="flex-1 text-center px-3 py-1">Questions</h2>
                <div class="w-80 flex">
                    <div
                        class="flex-1 text-center flex items-center justify-center px-3 py-1"
                    >
                        Answer
                    </div>
                    <div
                        class="flex-1 text-center flex items-center justify-center px-3 py-1"
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
                        class="flex-1 text-center border-r border-blue-200 px-3 py-4"
                    >
                        {{ lesson.lesson_question }}
                    </h2>
                    <div class="w-80 flex">
                        <div
                            class="flex-1 text-center flex items-center justify-center px-3 py-3 text-green-600"
                        >
                            {{ lesson.correct_answer }}
                        </div>
                        <div
                            class="flex-1 text-center flex items-center justify-center px-3 py-3 border-l border-blue-200"
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
                class="max-md:fixed max-md:bottom-16 max-md:px-5 max-md:left-0 w-full flex justify-between"
            >
                <Link
                    :href="route('exam.index')"
                    class="py-2 px-5 border-2 border-blue-500 rounded-md text-blue-500 font-semibold"
                >
                    Back to exams
                </Link>

                <button
                    class="select-none py-2 px-5 border-2 border-blue-500 rounded-md bg-main_bg text-white font-semibold"
                >
                    Retake
                </button>
            </form> -->
        </div>
    </div>
</template>
