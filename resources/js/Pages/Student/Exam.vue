<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link, useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

import ExamCountdown from "@/Components/ExamCountdown.vue";

const { lesson, choices, current_page, lessons_count, category_id, exam_id } =
    defineProps({
        lesson: Object,
        choices: Object,
        current_page: String,
        lessons_count: Number,
        category_id: Number,
        exam_id: Number,
    });

const exit = ref("/img/exit.svg");

const form = useForm({
    exam_id: exam_id,
    lesson_id: lesson.id,
    current_page: current_page,
    choice_id: "",
    not_answered: 0,
});

const submit = () => {
    form.post(route("exam.answer.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};

function time_ended_submit() {
    form.choice_id = 1;
    form.not_answered = 1;
    form.post(route("exam.answer.store"));
}
</script>

<template>
    <Head title="Exam" />

    <div class="w-full h-screen flex justify-center max-md:mt-6">
        <form
            @submit.prevent="submit"
            class="w-[800px] max-xl:w-full my-10 mb-60 max-sm:mb-20 max-md:mt-20 flex flex-col justify-between relative select-none"
        >
            <div class="flex flex-col">
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
                    <ExamCountdown
                        :time_remaining="lesson.time_remaining"
                        @time_ended_submit="time_ended_submit()"
                    />
                    <span
                        class="w-fit h-fit px-3 py-3 bg-blue-200 rounded-md text-blue-500 max-md:text-sm max-md:py-2 max-md:px-2"
                        >{{ current_page }}/{{ lessons_count }}</span
                    >
                </div>
                <div class="flex flex-col items-center gap-10 mt-10">
                    <p class="text-center text-xl max-md:text-base">
                        {{ lesson.lesson_question }}
                    </p>
                    <div class="flex flex-col w-full gap-2">
                        <div v-for="choice in choices" class="flex w-full">
                            <input
                                type="radio"
                                :id="choice.id"
                                name="fav_language"
                                :value="choice.id"
                                v-model="form.choice_id"
                                class="hidden"
                            />
                             
                            <label
                                :for="choice.id"
                                class="max-md:text-sm w-full px-5 py-2 border border-blue-200 rounded-md hover:bg-blue-200 cursor-pointer"
                                :class="{
                                    'bg-blue-200 text-blue-800':
                                        form.choice_id == choice.id,
                                }"
                                >{{ choice.choice_description }}</label
                            >
                             
                        </div>
                        <div v-if="form.errors.choice_id" class="text-red-500">
                            Select your choice
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="max-md:fixed max-md:bottom-16 max-md:px-5 max-md:left-0 w-full flex justify-between items-center"
            >
                <div class=""></div>
                <div v-if="current_page == lessons_count">
                    <button
                        class="select-none py-2 px-5 border-2 border-blue-500 rounded-md bg-main_bg text-white font-semibold"
                    >
                        Finish
                    </button>
                </div>
                <div v-else>
                    <button
                        class="select-none py-2 px-5 border-2 border-blue-500 rounded-md bg-main_bg text-white font-semibold"
                    >
                        Next
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
