<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { Link, Head } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import ElementDetails from "@/Components/ElementDetails.vue";
import StoreEmbed from "@/Components/Instructor/StoreEmbed.vue";
import Flash from "@/Components/Flash.vue";

const { lessons, status } = defineProps({
    lessons: Object,
    status: String,
});

let show_details = ref(false);
let show_flash = ref(false);

const check_green = ref("/img/check_green.svg");
const view = ref("/img/view.svg");
const cancel = ref("/img/cancel.svg");

const baseUrl = window.location.origin + "/storage/";
</script>

<template>
    <Head :title="status + ' lessons'" />

    <transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="transform opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-700 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="transform opacity-0"
    >
        <Flash
            v-if="$page.props.flash.message"
            :message="$page.props.flash.message"
            :color="$page.props.flash.color"
            @close_flash="
                ($page.props.flash.message = null),
                    ($page.props.flash.color = null)
            "
        />
    </transition>

    <div
        class="flex items-center justify-between w-full gap-5 mt-2 max-lg:flex-col max-lg:items-start max-md:gap-2"
    >
        <h1
            class="text-3xl font-semibold text-blue-800 capitalize max-md:mt-20 max-md:mb-2 max-md:text-2xl"
        >
            {{ status }} lessons
        </h1>
    </div>

    <div
        class="w-full pb-10 mt-5 overflow-x-auto max-md:mt-2"
        :class="{ 'opacity-0': show_details }"
    >
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-lg:mr-24 max-md:mr-0 max max-sm:w-[900px]"
            style=""
        >
            <thead>
                <tr
                    class="space-y-3 text-white border border-blue-500 text-start text-btn bg-main_bg whitespace-nowrap"
                >
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        No.
                    </th>
                    <th class="py-5 font-semibold text-left max-md:py-3">
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
                        Embedded Video
                    </th>
                    <th class="py-5 pl-5 font-semibold text-left max-md:py-3">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="(lesson, index) in lessons.data"
                    :key="index"
                    class="text-sm border border-blue-300 md:text-base lg:text-lg font-regular"
                >
                    <td class="py-3 pl-5">{{ index + 1 }}</td>
                    <td class="py-3 pl-5 w-44">{{ lesson.category_name }}</td>
                    <td class="py-3 pl-5">{{ lesson.item_count }}</td>
                    <td class="py-3 pl-5">
                        <span
                            class="px-3 py-2 text-sm text-yellow-800 bg-yellow-300 rounded-md max-md:text-xs max-md:py-1"
                            >{{ lesson.status }}</span
                        >
                    </td>
                    <td class="py-3 pl-5">{{ lesson.uploaded_by }}</td>
                    <td class="py-3 pl-5">{{ lesson.date }}</td>
                    <td class="py-3 pl-5">
                        <ElementDetails v-if="lesson.pdf" details="View PDF">
                            <a
                                :href="baseUrl + lesson.pdf"
                                target="_blank"
                                rel="noopener noreferrer"
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
                            </a>
                        </ElementDetails>
                        <div v-else>N/A</div>
                    </td>
                    <td class="py-3 pl-5">
                        <StoreEmbed
                            :category_id="lesson.id"
                            :embed="lesson.embed"
                            :status="status"
                        />
                    </td>
                    <td class="py-3 pl-5">
                        <div class="flex items-center gap-2">
                            <ElementDetails details="View Questionnaire">
                                <Link
                                    :href="
                                        route('dean.lessons.show', [
                                            lesson.id,
                                            1,
                                        ])
                                    "
                                >
                                    <div
                                        class="p-2 bg-blue-100 rounded-md cursor-pointer select-none hover:bg-blue-200 active:bg-blue-100"
                                    >
                                        <img :src="view" alt="" class="h-5" />
                                    </div>
                                </Link>
                            </ElementDetails>
                            <ElementDetails
                                v-if="status != 'approved'"
                                details="Approve"
                            >
                                <Link
                                    :href="
                                        route('dean.lessons.update', [
                                            lesson.id,
                                            'approved',
                                        ])
                                    "
                                    method="post"
                                    as="button"
                                    type="button"
                                >
                                    <div
                                        class="p-2 bg-[#C1F9B8] rounded-md select-none cursor-pointer hover:bg-green-300 active:bg-green-100"
                                    >
                                        <img
                                            :src="check_green"
                                            alt=""
                                            class="h-5"
                                        />
                                    </div>
                                </Link>
                            </ElementDetails>
                            <ElementDetails
                                v-if="status != 'disapproved'"
                                details="Disapprove"
                            >
                                <Link
                                    :href="
                                        route('dean.lessons.update', [
                                            lesson.id,
                                            'disapproved',
                                        ])
                                    "
                                    method="post"
                                    as="button"
                                    type="button"
                                >
                                    <div
                                        class="p-2 bg-red-200 rounded-md cursor-pointer select-none hover:bg-red-300 active:bg-red-100"
                                    >
                                        <img :src="cancel" alt="" class="h-5" />
                                    </div>
                                </Link>
                            </ElementDetails>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="lessons.links" />
    </div>
</template>
