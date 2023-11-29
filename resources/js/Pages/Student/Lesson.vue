<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link } from "@inertiajs/vue3";

const { lesson, current_page, lessons_count, category_id } = defineProps({
    lesson: Object,
    current_page: String,
    lessons_count: Number,
    category_id: Number,
});
</script>

<template>
    <div class="w-full h-screen flex justify-center max-md:mt-6">
        <div class="w-[1200px] py-10 my-10">
            <span class="px-3 py-3 bg-blue-200 rounded-md text-blue-500 max-md:text-sm max-md:py-2 max-md:px-2"
                >{{ current_page }}/{{ lessons_count }}</span
            >
            <div class="flex flex-col items-center gap-10 mt-10">
                <p class="text-center text-xl  max-md:text-base">
                    {{ lesson.lesson_question }}
                </p>

                <span>Answer: {{ lesson.correct_answer.choice.choice_description }}</span>

                <div class="w-full flex justify-between">
                  
                  <div v-if="current_page == 1">
                    <Link
                        :href="
                            route('category.index')
                        "
                        class="py-2 px-5 border-2 border-blue-500 rounded-md text-blue-500 font-semibold"
                    >
                        Back to lessons
                    </Link>
                  </div>
                  <div v-else>
                    <Link
                        :href="
                            route('test.index', [
                                category_id,
                                parseInt(current_page) - 1,
                            ])
                        "
                        class="py-2 px-5 border-2 border-blue-500 rounded-md text-blue-500 font-semibold"
                    >
                        Back
                    </Link>
                  </div>
                   
                  <div v-if="current_page == lessons_count">
                    
                    <Link
                        :href="
                            route('category.index')
                        "
                        class="py-2 px-5 border-2 border-blue-500 rounded-md bg-blue-500 text-white font-semibold"
                    >
                        Finish
                    </Link>
                  </div>
                  <div v-else>
                    <Link
                        :href="
                            route('test.index', [
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
    </div>
</template>
