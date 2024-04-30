<script setup>
import { ref } from "vue";
import { Collapse } from "vue-collapsed";

import CategoryCard from "@/Components/CategoryCard.vue";

const drop = ref("/img/drop.svg");

const { major } = defineProps({
    major: Object,
});

const show_details = ref(false);
</script>

<template>
    <!-- Event header -->
    <div
        id="event container"
        class="bg-[#F4F8FF] border-t border-l border-r border-blue-200"
    >
        <div
            class="flex items-center justify-between border-b border-blue-200 cursor-pointer select-none bg-gradient-to-r from-main_bg to-gray-400"
            :class="{ 'pr-0 pl-4': is_owner }"
        >
            <div
                @click="show_details = !show_details"
                class="flex items-center justify-between flex-1 px-4 py-3"
            >
                <div class="flex flex-col justify-around gap-1 pr-5">
                    <h1 class="text-base font-semibold text-white">
                        {{ major.major_name }}
                    </h1>
                </div>
                <img
                    :src="drop"
                    class="w-4 h-4 select-none"
                    :class="{ 'rotate-180': show_details, 'mr-3': is_owner }"
                    alt=""
                />
            </div>
        </div>

        <!-- Event details -->
        <Collapse :when="show_details" class="w-full overflow-hidden">
            <div
                class="flex flex-wrap items-center justify-center w-full gap-3 px-5 py-5 border-b border-blue-200 max-xl:flex-nowrap max-xl:flex-col max-sm:px-3 max-sm:py-3"
            >
                <CategoryCard
                    v-for="category in major.categories"
                    :category="category"
                    :major_id="major.id"
                />
            </div>
        </Collapse>
    </div>
</template>
