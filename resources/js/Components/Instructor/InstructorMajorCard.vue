<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Swal from "sweetalert2";

import FormProgress from "@/Components/FormProgress.vue";

const props = defineProps({
    major: {
        type: Object,
        required: true,
    },
});

const drop = ref("/img/drop.svg");
const baseUrl = window.location.origin;

const form = useForm({
    file: [],
    id: props.major.id,
});

const submit = () => {
    form.post(route("instructor.majors.store"), {
        onSuccess: () => {
            emit("close_it");
            form.reset("file");
        },
        onError: () => {
            Swal.fire({
                title: "Wrong excel format",
                text: form.errors.file,
                icon: "error",
                footer:
                    "<a href='" +
                    baseUrl +
                    "/img/format.png' target='_blank'>See sample format</a>",
            });
        },
    });
};
</script>

<template>
    <div
        class="w-[550px] px-6 py-5 bg-main_bg max-2xl:w-[450px] max-xl:w-full bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="flex flex-col justify-between w-full h-full gap-3">
            <div class="flex justify-between w-full h-full">
                <h2 class="text-2xl font-light text-white max-md:text-xl">
                    {{ props.major.major_name }}
                </h2>
                <img :src="drop" class="-rotate-90" />
            </div>
            <div class="flex justify-between w-full gap-4 text-center">
                <Link
                    :href="
                        route('instructor.lessons.index', [
                            props.major.id,
                            'pending',
                        ])
                    "
                    class="flex flex-col items-center flex-1 py-4 bg-white rounded-md cursor-pointer select-none bg-opacity-80 hover:bg-opacity-100 active:bg-opacity-80"
                >
                    <h2 class="text-2xl font-medium">
                        {{ props.major.category_pending_count }}
                    </h2>
                    <span class="text-xs text-gray-700">Pending Lessons</span>
                </Link>
                <Link
                    :href="
                        route('instructor.lessons.index', [
                            props.major.id,
                            'approved',
                        ])
                    "
                    class="flex flex-col items-center flex-1 py-4 bg-white rounded-md cursor-pointer select-none bg-opacity-80 hover:bg-opacity-100 active:bg-opacity-80"
                >
                    <h2 class="text-2xl font-medium">
                        {{ props.major.category_approved_count }}
                    </h2>
                    <span class="text-xs text-gray-700">Approved Lessons</span>
                </Link>
            </div>

            <div class="flex flex-col gap-1">
                <span class="text-white">Upload excel file:</span>
                <form
                    @submit.prevent="submit"
                    class="flex items-center justify-between px-5 py-3 bg-white border border-blue-100 rounded-md max-md:px-3 max-md:py-2 max-md:text-sm max-md:flex-col max-md:items-start max-md:gap-3 bg-opacity-80"
                >
                    <div class="flex items-center gap-5">
                        <label
                            :for="major.id"
                            :class="{ hidden: form.progress }"
                            class="px-3 py-2 text-white rounded cursor-pointer select-none bg-main_bg whitespace-nowrap hover:bg-blue-400"
                        >
                            <input
                                type="file"
                                :id="major.id"
                                @input="form.file = $event.target.files[0]"
                                accept=".xlsx, .xls"
                                class="hidden"
                            />
                            Choose file
                        </label>
                        <span>{{
                            form.file.length != 0
                                ? form.file.name
                                : "No file chosen"
                        }}</span>
                    </div>
                    <button
                        class="px-3 py-2 text-white bg-blue-200 rounded max-md:w-full"
                        :disabled="form.file.length == 0"
                        :class="{ 'bg-main_bg': form.file.length != 0 }"
                    >
                        submit
                    </button>
                </form>
            </div>
            <div></div>
            <FormProgress
                v-if="form.progress"
                :percent="form.progress.percentage"
            />
        </div>
    </div>
</template>
