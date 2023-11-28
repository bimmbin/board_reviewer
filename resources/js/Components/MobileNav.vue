<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import DashNav from "@/Components/DashNav.vue";

const close_img = ref("/img/close.svg");

const emit = defineEmits(["close_emit"]);

const logo = ref("/img/logo.png");
</script>

<template>
    <div
        class="w-screen fixed top-0 left-0 h-screen bg-black bg-opacity-80 z-10 flex select-none"
    >
        <div
            class="flex-1 h-full bg-gray2 px-7 max-sm:px-5 py-5 z-20 flex flex-col gap-20"
        >
            <!-- Logo -->
            <Link class="flex items-center gap-2 px-3">
                <img :src="logo" alt="" class="h-7 max-md:h-6" />
                <h1 class="text-3xl max-md:text-2xl font-semibold">Vinrecs</h1>
            </Link>

            <!-- navigation -->
            <div class="h-full flex flex-col gap-10 sticky left-0 top-0">
                <DashNav
                    image="chcc_logo"
                    nav_name="Create"
                    :href="route('lessons.index')"
                    @click="$emit('close_emit')"
                />
            </div>
        </div>
        <div
            class="w-[30%] h-full cursor-pointer"
            @click="$emit('close_emit')"
        ></div>
    </div>
</template>
