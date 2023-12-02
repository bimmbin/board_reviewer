<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import DashNav from "@/Components/DashNav.vue";
import DashDrop from "@/Components/DashDrop.vue";

const close_img = ref("/img/close.svg");
const logout = ref("/img/logout.svg");

const emit = defineEmits(["close_emit"]);

const chcc_logo = ref("/img/chcc_logo.png");
</script>

<template>
    <div
        class="w-screen fixed top-0 left-0 h-screen bg-black bg-opacity-80 z-10 flex select-none"
    >
        <div
            class="flex-1 h-full bg-blue-500 px-7 max-sm:px-5 py-5 z-20 flex flex-col gap-20"
        >
            <!-- Logo -->
            <Link class="flex items-center gap-2 px-3">
                <img :src="chcc_logo" alt="" class="h-7 max-md:h-6" />
                <h1 class="text-3xl max-md:text-2xl font-semibold text-white">
                    ILE
                </h1>
            </Link>

            <!-- navigation -->
            <div class="flex flex-col sticky left-0 top-0">
                <DashNav
                    image="project"
                    nav_name="Lessons"
                    :href="route('category.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/student/lessons')"
                />
                <DashNav
                    image="project"
                    nav_name="Exam"
                    href="sdfasdf"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/sdfsdf')"
                />
                <DashDrop image="project" nav_name="Recents">
                    <DashNav
                        image="project"
                        nav_name="Lessons"
                        :href="route('category.index')"
                        @click="$emit('close_emit')"
                        :active="$page.url.startsWith('/student/lessons')"
                        :sub_nav="true"
                    />
                </DashDrop>
                
            </div>
            <Link
                    v-if="$page.props.auth.user"
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-blue-500 bg-white border border-main rounded-md py-3 flex justify-center items-center gap-5 hover:bg-blue-200 hover:text-blue-800"
                >
                    Logout
                    <img :src="logout" class="h-3" />
                </Link>
        </div>
        <div
            class="w-[30%] h-full cursor-pointer"
            @click="$emit('close_emit')"
        ></div>
    </div>
</template>
