<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});
let page_number = ref();
if ((props.category.page_views.length == 0)||(props.category.page_views.length == props.category.lessons.length)) {
  page_number = 1;
} else {
  page_number = props.category.page_views.length + 1;
}


const lesson_icon = ref("/img/lesson_icon.svg");
const check = ref("/img/check.svg");
</script>

<template>
    <Link
        :href="route('test.index', [props.category.id, page_number])"
        class="w-[550px] px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-400 max-2xl:w-[450px] max-xl:w-full h-52 max-sm:h-40 bg-gray2 flex flex-col justify-between rounded-xl"
    >
        <div class="w-full h-full flex flex-col justify-between">
            <div class="flex justify-between items-center">
                <img :src="lesson_icon" alt="" class="w-12 max-md:w-10" />
                <span v-if="(props.category.page_views.length != 0)&&(props.category.page_views.length != props.category.lessons.length)" class="bg-white px-3 py-2 max-md:px-2 max-md:py-1 rounded-md text-blue-500 max-md:text-sm">{{ props.category.page_views.length }}/{{ props.category.lessons.length }}</span>
                <img v-if="props.category.page_views.length == props.category.lessons.length" :src="check" alt="" class="w-12 max-md:w-10" />
                
            </div>
            <div class="flex items-center">
                <h2 class="text-white text-2xl font-light max-md:text-xl">
                    {{ props.category.category_name }}
                </h2>
            </div>
        </div>
    </Link>
</template>
