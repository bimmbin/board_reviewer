<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import Category from "../Student/Category.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import CancelLesson from "@/Components/Instructor/CancelLesson.vue";
import ElementDetails from "@/Components/ElementDetails.vue";
import UploadPdf from "@/Components/Instructor/UploadPdf.vue";

const { lessons, status } = defineProps({
    lessons: Object,
    status: String,
});

let show_details = ref(false);
let show_view = ref(false);

const cancel = ref("/img/cancel.svg");

const baseUrl = window.location.origin + "/public/pdf/";
</script>

<template>
    <Head :title="status + ' lessons'" />
    <div
        class="flex items-center justify-between w-full gap-5 mt-2 max-lg:flex-col max-lg:items-start max-md:gap-2"
    >
        <div
            class="flex items-center mb-3 text-3xl font-bold capitalize max-md:mt-20 text-main_bg max-md:mb-2 max-md:text-2xl"
        >
            {{ status }} Lessons
        </div>
    </div>

    <div
        class="w-full pb-10 mt-5 overflow-x-auto max-md:mt-2"
        :class="{ 'opacity-0': show_details }"
    >
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-lg:mr-24 max-md:mr-0 max max-sm:w-[900px] text-lg"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm text-white border border-blue-500 md:text-base lg:text-lg text-start text-btn bg-main_bg"
                >
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        No.
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Lesson Name
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Items
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Status
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Uploaded by
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Date
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        PDF
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize whitespace-nowrap">
                <tr
                    v-for="(lesson, index) in lessons.data"
                    :key="index"
                    class="text-sm border border-blue-300 md:text-base lg:text-lg font-regular"
                >
                    <td class="py-3 pl-5">{{ index + 1 }}</td>
                    <td class="py-3 pl-5">{{ lesson.category_name }}</td>
                    <td class="py-3 pl-5">{{ lesson.item_count }}</td>
                    <td class="py-3 pl-5">
                        <span
                            class="px-3 py-2 text-sm text-yellow-800 bg-yellow-300 rounded-md max-md:text-xs max-md:py-1"
                            >{{ lesson.status }}</span
                        >
                    </td>
                    <td class="py-3 pl-5">{{ lesson.uploaded_by }}</td>
                    <td class="py-3 pl-5">{{ lesson.date }}</td>
                    <!-- PDF Form -->
                    <td class="py-3 pl-5">
                        <UploadPdf
                            :category_id="lesson.id"
                            :pdf="lesson.pdf"
                            :status="status"
                        />
                    </td>
                    <td class="py-3 pl-5">
                        <div class="flex items-center gap-2">
                            <ElementDetails details="View Questionnaire">
                                <Link
                                    :href="
                                        route('instructor.lessons.show', [
                                            lesson.id,
                                            1,
                                        ])
                                    "
                                >
                                    <div
                                        class="p-2 bg-blue-100 rounded-md cursor-pointer select-none hover:bg-blue-200 active:bg-blue-100"
                                    >
                                        <img
                                            src="/img/view.svg"
                                            alt=""
                                            class="h-5"
                                        />
                                    </div>
                                </Link>
                            </ElementDetails>
                            <CancelLesson :lesson_id="lesson.id" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="lessons.links" />
    </div>
</template>
