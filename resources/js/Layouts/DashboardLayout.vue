<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import DashNav from "@/Components/DashNav.vue";
import MobileNav from "@/Components/MobileNav.vue";
import UserInfo from "@/Components/UserInfo.vue";

import "typeface-poppins";
const chcc_logo = ref("/img/chcc_logo.png");
const burger = ref("/img/burger.svg");
const logout = ref("/img/logout.svg");

const show_nav = ref(false);
</script>

<template>
    <div class="flex font-pop bg-portbg">
        <!-- navigation -->
        <div
            class="h-screen bg-blue-500 flex flex-col max-md:hidden sticky left-0 top-0"
        >
            <!-- Logo -->
            <div class="flex justify-center gap-2 px-3 py-5">
                <img :src="chcc_logo" alt="" class="h-32 max-md:h-6" />
            </div>
            <UserInfo></UserInfo>
            <!-- <UserInfo :user="Auth::user()"/> -->
            <div class="mt-20">
                <!-- <DashNav
                    image="project"
                    nav_name="Create"
                    :href="route('category.index')"
                    @click="$emit('close_emit')"
                /> -->
                <DashNav
                    image="project"
                    nav_name="Lessons"
                    :href="route('category.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/student/lessons')"
                />
            </div>

            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="w-[80%] m-auto text-blue-500 bg-white border rounded-md py-3 flex justify-center items-center gap-5  hover:text-blue-800 hover:border-blue-600"
            >
                Logout
                <img :src="logout" class="h-3">
            </Link>
        </div>
        <div
            class="w-[1180px] min-h-screen mx-auto max-2xl:w-[1000px] max-xl:w-[1000px] max-md:w-screen max-md:px-5 py-5 max-sm:py-0 text-black max-xl:px-10"
        >
            <!-- Header -->
            <div
                class="flex justify-between bg-blue-500 items-center bg-gray1 absolute z-10 top-0 left-0 w-full py-2 px-5 text-black md:hidden"
            >
                <div>
                    <img :src="chcc_logo" alt="" class="h-12" />
                </div>
                <div
                    class="lg:hidden cursor-pointer select-none"
                    @click="show_nav = !show_nav"
                >
                    <img :src="burger" alt="" class="h-6" />
                </div>
            </div>
            <!-- Responsive Nav -->
            <div v-if="show_nav">
                <MobileNav @close_emit="show_nav = !show_nav" />
            </div>
            <slot></slot>
        </div>
    </div>
</template>
