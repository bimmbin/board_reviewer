<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { format } from "date-fns";

import Countdown from "@/Components/Countdown.vue";

const { recent_lessons } = defineProps({
    recent_lessons: Object,
});

const formatDate = (dateString) => {
    return format(new Date(dateString), "MMMM dd, yyyy"); // Customize the format as needed
};
const formatTime = (dateString) => {
    return format(new Date(dateString), "hh:mm a"); // Customize the format as needed
};

</script>

<template>
    <h1
        class="text-3xl font-semibold mb-5 max-md:mt-20 text-blue-800 max-md:mb-2"
    >
        Recent lessons 
    </h1>
    <div class="w-full pb-10 overflow-x-auto">
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-sm:w-[900px] text-lg xl:w-full"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-main_bg text-white"
                >
                    <th class="text-left pl-5 py-5 font-semibold">Topic</th>
                    <th class="text-left py-5 font-semibold">Date</th>
                    <th class="text-left py-5 font-semibold">Time</th>
                    <th class="text-left py-5 font-semibold">Completed</th>
                    <th class="text-left py-5 font-semibold">Status</th>
                    <th class="text-left py-5 font-semibold">Action</th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr
                    v-for="(recent_lesson, index) in recent_lessons"
                    :key="index"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">
                        {{ recent_lesson.category.category_name }}
                    </td>

                    <td>{{ formatDate(recent_lesson.created_at) }}</td>
                    <td>
                      {{ formatTime(recent_lesson.created_at) }}
                        <!-- <Countdown :time="recent_lesson.seconds" :time_ended="recent_lesson.time_ended == 1"/> -->
                    </td>
                    <td>
                        {{ recent_lesson.page_views.length }}/{{
                            recent_lesson.category.lessons.length
                        }}
                    </td>
                    <td>
                        <span
                            v-if="
                                recent_lesson.page_views.length ==
                                recent_lesson.category.lessons.length
                            "
                            class="px-3 py-2 bg-green-300 text-green-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >Finished</span
                        >
                        <span
                            v-else
                            class="px-3 py-2 bg-yellow-300 text-yellow-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >Unfinished</span
                        >
                    </td>
                    <td>
                        <Link
                            v-if="
                                recent_lesson.page_views.length ==
                                    recent_lesson.category.lessons.length ||
                                recent_lesson.time_ended
                            "
                            :href="
                                route('lesson.store', [
                                    recent_lesson.category.id,
                                    1,
                                ])
                            "
                            class="underline text-base max-md:text-sm"
                            >Retake</Link
                        >
                        <Link
                            v-else
                            :href="
                                route('lesson.index', [
                                    recent_lesson.id,
                                    recent_lesson.category.id,
                                    recent_lesson.page_views.length + 1,
                                ])
                            "
                            class="flex items-center gap-2"
                            ><span class="underline text-base max-md:text-sm"
                                >Continue</span
                            >
                            <span class="text-sm text-red-500 max-md:text-xs"
                                >{{
                                    recent_lesson.time_remaining
                                }}
                                remaining</span
                            ></Link
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
