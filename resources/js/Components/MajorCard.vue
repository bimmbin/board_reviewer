<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    major: {
        type: Object,
        required: true,
    },
});

const drop = ref("/img/drop.svg");

const form = useForm({
    file: [],
    id: props.major.id,
});

const submit = () => {
    form.post(route("majors.store"));
};
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
            <div class="w-full flex items-center justify-between gap-4">
              <div class="bg-white flex-1 rounded-md flex flex-col items-center py-4 bg-opacity-80 hover:bg-opacity-100 cursor-pointer active:bg-opacity-80 select-none">
                <h2 class="text-2xl font-medium ">{{ props.major.categories_count }}</h2>
                <span class="text-xs text-gray-700 ">Lessons</span>
              </div>
              <Link :href="route('students.show', props.major.id)" class="bg-white flex-1 rounded-md flex flex-col items-center py-4 bg-opacity-80 hover:bg-opacity-100 cursor-pointer active:bg-opacity-80 select-none">
                <h2 class="text-2xl font-medium ">{{ props.major.students_count }}</h2>
                <span class="text-xs text-gray-700 ">Students</span>
              </Link>
            </div>
            <!-- <form @submit.prevent="submit" class="">
                <input
                    type="file"
                    id="file"
                    @input="form.file = $event.target.files[0]"
                    accept=".xlsx, .xls"
                />
                <button class="bg-white px-3 py-1 rounded-md">submit</button>
            </form> -->
        </div>
    </div>
</template>
