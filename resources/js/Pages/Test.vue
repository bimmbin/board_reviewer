<script setup>
import { Link } from "@inertiajs/vue3";

const { lesson, current_page, lessons_count } = defineProps({
    lesson: Object,
    current_page: String,
    lessons_count: Number,
});
</script>

<template>
    <div class="w-full h-screen flex justify-center">
        <div class="w-[1200px] py-10 my-10">
            <span>{{ current_page }}/{{ lessons_count }}</span>
            <div class="flex flex-col items-center gap-10 mt-10">
                <p class="text-center text-xl">
                    {{ lesson.lesson_question }}
                </p>
                <div
                    v-for="choice in lesson.choices"
                    class="flex gap-2 items-center"
                >
                    <input
                        type="radio"
                        :id="choice.id"
                        name="fav_language"
                        :value="choice.choice_index"
                    />
                    <label :for="choice.id">{{
                        choice.choice_description
                    }}</label
                    ><br />
                </div>

                <div class="w-full flex justify-between">
                    <Link
                        :href="
                            route('test.index', parseInt(current_page - 1) - 1)
                        "
                        class="py-2 px-5 border-2 border-blue-500 rounded-md text-blue-500 font-semibold"
                    >
                        Back
                    </Link>
                    <Link
                        :href="route('test.index', parseInt(current_page) + 1)"
                        class="py-2 px-5 border-2 border-blue-500 rounded-md bg-blue-500 text-white font-semibold"
                    >
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
