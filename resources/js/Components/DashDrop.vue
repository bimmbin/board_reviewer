<script setup>
import { ref, onMounted } from "vue";
import { Collapse } from "vue-collapsed";
import { usePage } from "@inertiajs/vue3";

defineProps({
    image: {
        type: String,
    },
    nav_name: {
        type: String,
    },
});

const page = usePage();

const img_path = ref("/img/");
const drop = ref("/img/drop.svg");

let show_details = ref(false);


</script>

<template>
    <!-- collapse header -->
    <div
        @click="show_details = !show_details"
        class="flex justify-between items-center cursor-pointer active:bg-blue-300 hover:bg-hover_bg text-white gap-3 hover:bg-gray2 px-10 py-3 select-none"
    >
        <div class="flex justify-between items-center w-full gap-8">
            <div class="flex items-center gap-3">
                <img :src="img_path + image + '.svg'" class="w-4 h-4" />
                <span class="text-white text-lg max-sm:text-base">{{ nav_name }}</span>
            </div>

            <img
                :src="drop"
                class="w-4 h-4 select-none"
                :class="{ '-rotate-180 transition ease-linear': show_details }"
                alt=""
            />
        </div>
    </div>

    <!-- collapse details -->
    <Collapse
        :when="show_details"
        class="w-full overflow-hidden flex flex-col "
    >
        <slot></slot>
    </Collapse>
</template>
