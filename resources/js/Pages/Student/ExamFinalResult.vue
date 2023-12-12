<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const { exam, correct_count, lesson_count } = defineProps({
    exam: Object,
    correct_count: Number,
    lesson_count: Number,
});
const trophy = ref("/img/trophy.png");
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
                        <span class="font-medium text-blue-700"
                            >{{ exam.category.major.major_name }}
                            {{ exam.category.category_name }}</span
                        >
                    </p>
                </div>
                <span
                    class="text-2xl px-5 py-3 bg-blue-200 rounded-md text-blue-700 max-md:text-base max-md:px-4"
                    >{{ correct_count }}/{{ lesson_count }}</span
                >
            </div>
            <div
                class="max-md:fixed max-md:bottom-16 max-md:px-5 max-md:left-0 w-full flex justify-between"
            >
                <Link
                    :href="route('exam.index')"
                    class="py-2 px-5 border-2 border-blue-500 rounded-md text-blue-500 font-semibold"
                >
                    Back to exams
                </Link>

                <Link
                    class="py-2 px-5 border-2 border-blue-500 rounded-md bg-blue-500 text-white font-semibold"
                >
                    Retake 
                </Link>
            </div>
        </div>
    </div>
</template>
