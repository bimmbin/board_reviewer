<script>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

export default {
    layout: DashboardLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import ElementDetails from "@/Components/ElementDetails.vue";
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

</script>

<template>
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
            @close_flash="$page.props.flash.message = null, $page.props.flash.color = null"
        />
    </transition>

    <div
        class="w-full flex items-center justify-between gap-5 max-lg:flex-col max-lg:items-start max-md:gap-2 mt-2"
    >
        <h1
            class="text-3xl font-semibold max-md:mt-20 text-blue-800 max-md:mb-2 max-md:text-2xl capitalize"
        >
            {{ status }} lessons
        </h1>
    </div>

    <div
        class="w-full pb-10 overflow-x-auto mt-5 max-md:mt-2"
        :class="{ 'opacity-0': show_details }"
    >
        <table
            id="dataTable"
            class="table-auto text-center w-[1220px] max-lg:w-[1080px] max-lg:mr-24 max-md:mr-0 max max-sm:w-[900px] text-lg"
            style="font-size: clamp(0.875rem, 0.75rem + 0.3125vw, 1.125rem)"
        >
            <thead>
                <tr
                    class="space-y-3 text-sm md:text-base border border-blue-500 lg:text-lg text-start text-btn bg-blue-500 text-white"
                >
                    <th class="text-left pl-5 py-5 max-md:py-3 font-semibold">
                        No.
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Lesson Name
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Items
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Status
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Uploaded by
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Date
                    </th>
                    <th class="text-left py-5 max-md:py-3 font-semibold">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="text-left capitalize">
                <tr
                    v-for="(lesson, index) in lessons.data"
                    :key="index"
                    class="border border-blue-300 text-sm md:text-base lg:text-lg font-regular"
                >
                    <td class="pl-5 py-3">{{ index + 1 }}</td>
                    <td>{{ lesson.category_name }}</td>
                    <td>{{ lesson.item_count }}</td>
                    <td>
                        <span
                            class="px-3 py-2 bg-yellow-300 text-yellow-800 rounded-md text-sm max-md:text-xs max-md:py-1"
                            >{{ lesson.status }}</span
                        >
                    </td>
                    <td>{{ lesson.uploaded_by }}</td>
                    <td>{{ lesson.date }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <ElementDetails details="View">
                                <Link
                                    :href="
                                        route('dean.lessons.show', [
                                            lesson.id,
                                            1,
                                        ])
                                    "
                                >
                                    <div
                                        class="p-2 bg-blue-100 rounded-md select-none cursor-pointer hover:bg-blue-200 active:bg-blue-100"
                                    >
                                        <img :src="view" alt="" class="h-5" />
                                    </div>
                                </Link>
                            </ElementDetails>
                            <ElementDetails v-if="status != 'approved'" details="Approve">
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
                            <ElementDetails v-if="status != 'disapproved'" details="Disapprove">
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
                                        class="p-2 bg-red-200 rounded-md select-none cursor-pointer hover:bg-red-300 active:bg-red-100"
                                    >
                                        <img
                                            :src="cancel"
                                            alt=""
                                            class="h-5"
                                        />
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
