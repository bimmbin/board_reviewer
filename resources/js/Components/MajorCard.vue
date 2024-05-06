<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    major: {
        type: Object,
        required: true,
    },
});

const drop = ref("/img/drop.svg");

const submit = () => {
    form.post(route("majors.store"));
};
</script>

<template>
    <div
        class="w-[550px] px-6 py-5 bg-[#3d6ca5] max-xl:w-full bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="flex flex-col justify-between w-full h-full gap-3">
            <div class="flex justify-between w-full h-full">
                <h2 class="text-2xl font-light text-white max-md:text-xl">
                    Students
                </h2>
                <img :src="drop" class="-rotate-90" />
            </div>
            <div class="flex justify-between w-full gap-4 text-center">
                <Link
                    :href="route('students.show', props.major.id)"
                    class="flex flex-col items-center flex-1 py-4 bg-white rounded-md cursor-pointer select-none bg-opacity-80 hover:bg-opacity-100 active:bg-opacity-80"
                >
                    <h2 class="text-2xl font-medium">
                        {{ props.major.students_count }}
                    </h2>
                    <span class="text-xs text-gray-700">Students</span>
                </Link>
            </div>
        </div>
    </div>
</template>
