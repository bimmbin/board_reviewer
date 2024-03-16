<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const { exam, lessons, correct_count, lesson_count } = defineProps({
    exam: Object,
    lessons: Object,
    correct_count: Number,
    lesson_count: Number,
});
const trophy = ref("/img/trophy.png");

const form = useForm({
    major_id: exam.major.id,
});

const submit = () => {
    form.post(route("exam.store"));
};
</script>

<template>
    <div class="w-full h-screen flex justify-center max-md:mt-6">
        <div
            class="w-[800px] max-xl:w-full my-10 mb-60 max-sm:mb-20 max-md:mt-20 flex flex-col justify-between relative"
        >
            <div class="flex flex-col gap-10 items-center">
                <img :src="trophy" class="w-40 max-md:w-24" />
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
                <span
                    class="text-2xl px-5 py-3 bg-blue-200 rounded-md text-blue-700 max-md:text-base max-md:px-4"
                    >{{ correct_count }}/{{ lesson_count }}</span
                >
            </div>
            <div class="w-full flex flex-col border-x border-t border-blue-200 bg-[#F4F8FF] text-sm">
              <div v-for="lesson in lessons" class="flex border-b border-blue-200">
                <h2 class="flex-1 text-center border-r border-blue-200 px-3 py-3">{{ lesson.lesson_question }}</h2>
                <div class="w-40 text-center flex items-center justify-center px-3 py-3 border-r border-blue-200 ">{{ lesson.correct_answer.choice.choice_description }}</div>
                <div class="w-40 text-center flex items-center justify-center px-3 py-3">{{ lesson.exam_answer ? lesson.exam_answer.choice.choice_description : 'no answer'}}</div>
              </div>
            </div>
            <form
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
            </form>
        </div>
    </div>
</template>
