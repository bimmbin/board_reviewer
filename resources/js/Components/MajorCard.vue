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
        <div class="w-full h-full flex flex-col justify-between gap-3">
            <div class="w-full h-full flex justify-between">
                <h2 class="text-white text-2xl font-light max-md:text-xl">
                    {{ props.major.student_major_name }}
                </h2>
                <img :src="drop" class="-rotate-90" />
            </div>
            <div class="w-full flex items-center justify-between gap-4">
              <Link :href="route('students.show', props.major.id)" class="bg-white flex-1 rounded-md flex flex-col items-center py-4 bg-opacity-80 hover:bg-opacity-100 cursor-pointer active:bg-opacity-80 select-none">
                <h2 class="text-2xl font-medium ">{{ props.major.students_count }}</h2>
                <span class="text-xs text-gray-700 ">Students</span>
              </Link>
            </div>
        </div>
    </div>
</template>
