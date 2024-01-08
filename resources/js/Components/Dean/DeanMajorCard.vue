<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

import FormProgress from "@/Components/FormProgress.vue";

const props = defineProps({
    major: {
        type: Object,
        required: true,
    },
});

const drop = ref("/img/drop.svg");


</script>

<template>
    <div
        class="w-[550px] px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-400 max-2xl:w-[450px] max-xl:w-full bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="w-full h-full flex flex-col justify-between gap-3">
            <div class="w-full h-full flex justify-between">
                <h2 class="text-white text-2xl font-light max-md:text-xl">
                    {{ props.major.major_name }}
                </h2>
                <img :src="drop" class="-rotate-90" />
            </div>
            <div class="w-full flex items-center justify-between gap-3">
                <Link
                    :href="route('dean.lessons.index', [props.major.id, 'pending'])"
                    class="bg-white flex-1 rounded-md flex flex-col items-center py-4 bg-opacity-80 hover:bg-opacity-100 cursor-pointer active:bg-opacity-80 select-none"
                >
                    <h2 class="text-2xl font-medium">
                        {{ props.major.category_pending_count }}
                    </h2>
                    <span class="text-xs text-gray-700">Pending Lessons</span>
                </Link>
                <Link
                    :href="route('dean.lessons.index', [props.major.id, 'approved'])"
                    class="bg-white flex-1 rounded-md flex flex-col items-center py-4 bg-opacity-80 hover:bg-opacity-100 cursor-pointer active:bg-opacity-80 select-none"
                >
                    <h2 class="text-2xl font-medium">
                        {{ props.major.category_approved_count }}
                    </h2>
                    <span class="text-xs text-gray-700">Approved Lessons</span>
                </Link>
                <Link
                    :href="route('dean.lessons.index', [props.major.id, 'disapproved'])"
                    class="bg-white flex-1 rounded-md flex flex-col items-center py-4 bg-opacity-80 hover:bg-opacity-100 cursor-pointer active:bg-opacity-80 select-none"
                >
                    <h2 class="text-2xl font-medium">
                        {{ props.major.category_disapproved_count }}
                    </h2>
                    <span class="text-xs text-gray-700">Disapproved Lessons</span>
                </Link>
            </div>

        </div>
    </div>
</template>
