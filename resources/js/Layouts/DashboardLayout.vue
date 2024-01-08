<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import DashNav from "@/Components/DashNav.vue";
import MobileNav from "@/Components/MobileNav.vue";
import UserInfo from "@/Components/UserInfo.vue";
import DashDrop from "@/Components/DashDrop.vue";

import "typeface-poppins";
const chcc_logo = ref("/img/chcc_logo.png");
const educ = ref("/img/educ.png");
const burger = ref("/img/burger.svg");
const logout = ref("/img/logout.svg");

const show_nav = ref(false);
</script>

<template>
    <div class="flex font-pop bg-portbg">
        <!-- navigation -->
        <div
            class="h-screen bg-blue-500 flex flex-col max-md:hidden sticky top-0 left-0"
        >
            <!-- Logo -->
            <div class="flex justify-center gap-2 px-3 py-5">
                <img :src="chcc_logo" alt="" class="h-32 max-md:h-6" />
            </div>
            <UserInfo></UserInfo>

            <!-- Admin Navigation -->
            <div
                v-if="$page.props.auth.user.user_role == 'admin'"
                class="mt-20"
            >
                <DashNav
                    image="project"
                    nav_name="Majors"
                    :href="route('majors.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/admin/majors')"
                />
                <DashNav
                    image="project"
                    nav_name="Instructors"
                    :href="route('instructors.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/instructors')"
                />
                <DashNav
                    image="project"
                    nav_name="Dean"
                    :href="route('dean.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/dean')"
                />
            </div>
            <!-- Student Navigation -->
            <div
                v-if="$page.props.auth.user.user_role == 'student'"
                class="mt-20"
            >
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
                    :href="route('exam.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/student/exam/categories')"
                />
                <DashDrop image="project" nav_name="History">
                    <DashNav
                        image="project"
                        nav_name="Lesson attempts"
                        :href="route('recent.lesson.index')"
                        @click="$emit('close_emit')"
                        :active="
                            $page.url.startsWith('/student/recents/lessons')
                        "
                        :sub_nav="true"
                    />
                    <DashNav
                        image="project"
                        nav_name="Exam attempts"
                        :href="route('recent.exam.index')"
                        @click="$emit('close_emit')"
                        :active="$page.url.startsWith('/student/recents/exams')"
                        :sub_nav="true"
                    />
                </DashDrop>
            </div>

            <!-- Instructor Navigation -->
            <div
                v-if="$page.props.auth.user.user_role == 'instructor'"
                class="mt-20"
            >
                <DashNav
                    image="project"
                    nav_name="Lists of Majors"
                    :href="route('instructor.majors.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/instructor/majors')"
                />
                <DashNav
                    image="project"
                    nav_name="Upload History"
                    :href="route('instructor.history.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/instructor/upload/history')"
                />
            </div>

            <!-- Dean Navigation -->
            <div
                v-if="$page.props.auth.user.user_role == 'dean'"
                class="mt-20"
            >
                <DashNav
                    image="project"
                    nav_name="Lists of Majors"
                    :href="route('dean.majors.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/majors/dean')"
                />
                <DashNav
                    image="project"
                    nav_name="Action History"
                    :href="route('dean.history.index')"
                    @click="$emit('close_emit')"
                    :active="$page.url.startsWith('/history/dean')"
                />
            </div>


            <!-- Logout -->
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="w-[80%] m-auto text-blue-500 bg-white border rounded-md py-3 flex justify-center items-center gap-5 hover:text-blue-800 hover:border-blue-600"
            >
                Logout
                <img :src="logout" class="h-3" />
            </Link>

             
        </div>
        <div
            class="w-[1180px] min-h-screen mx-auto max-2xl:w-[1000px] max-xl:w-[900px] max-lg:w-screen max-md:px-5 py-5 max-sm:py-0 text-black max-xl:px-10"
        >
            <!-- Header -->
            <div
                class="flex justify-between bg-blue-500 items-center bg-gray1 absolute z-10 top-0 left-0 w-full py-2 px-5 text-black md:hidden"
            >
                <div>
                    <Link :href="route('category.index')"
                        ><img :src="chcc_logo" alt="" class="h-12"
                    /></Link>
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
