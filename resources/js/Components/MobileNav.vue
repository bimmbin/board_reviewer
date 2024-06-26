<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import DashNav from "@/Components/DashNav.vue";
import DashDrop from "@/Components/DashDrop.vue";
import UserInfo from "@/Components/UserInfo.vue";

const logout = ref("/img/logout.svg");

const emit = defineEmits(["close_emit"]);

const chcc_logo = ref("/img/chcc_logo.png");
</script>

<template>
    <div
        class="w-screen fixed top-0 left-0 h-screen bg-black bg-opacity-80 z-10 flex select-none"
    >
        <div
            class="flex-1 h-full bg-main_bg px-7 max-sm:px-5 py-5 z-20 flex flex-col"
        >
            <!-- Logo -->
            <div class="flex justify-center">
                <Link
                    @click="$emit('close_emit')"
                    :href="route('category.index')"
                    ><img :src="chcc_logo" alt="" class="h-32"
                /></Link>
            </div>
            <div class="flex flex-col gap-20 mt-10">
                <UserInfo></UserInfo>

                <!-- admin navigation -->
                <div
                    v-if="$page.props.auth.user.user_role == 'admin'"
                    class="mt-20"
                >
                    <DashNav
                        image="project"
                        nav_name="Dashboard"
                        :href="route('main.dashboard.index')"
                        @click="$emit('close_emit')"
                        :active="$page.url.startsWith('/dashboard')"
                    />
                    <DashNav
                        image="project"
                        nav_name="Students"
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

                <!-- student navigation -->
                <div
                    v-if="$page.props.auth.user.user_role == 'student'"
                    class="mt-20"
                >
                    <div class="flex flex-col sticky left-0 top-0">
                        <DashNav
                            image="project"
                            nav_name="Dashboard"
                            :href="route('dashboard.index')"
                            @click="$emit('close_emit')"
                            :active="$page.url.startsWith('/student/dashboard')"
                        />
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
                            :active="
                                $page.url.startsWith('/student/exam/categories')
                            "
                        />
                        <DashNav
                            image="project"
                            nav_name="Assessment"
                            :href="route('recent.exam.index')"
                            @click="$emit('close_emit')"
                            :active="
                                $page.url.startsWith('/student/recents/exams')
                            "
                        />
                    </div>
                </div>

                <!-- instructor navigation -->
                <div
                    v-if="$page.props.auth.user.user_role == 'instructor'"
                    class="mt-20"
                >
                    <div class="flex flex-col sticky left-0 top-0">
                        <DashNav
                            image="project"
                            nav_name="Dashboard"
                            :href="route('main.dashboard.index')"
                            @click="$emit('close_emit')"
                            :active="$page.url.startsWith('/dashboard')"
                        />
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
                        <DashNav
                            image="project"
                            nav_name="Assessments"
                            :href="route('view.assessments.index')"
                            @click="$emit('close_emit')"
                            :active="$page.url.startsWith('/history/assessments')"
                        />
                    </div>
                </div>

                <!-- dean navigation -->
                <div
                    v-if="$page.props.auth.user.user_role == 'dean'"
                    class="mt-20"
                >
                    <div class="flex flex-col sticky left-0 top-0">
                        <DashNav
                            image="project"
                            nav_name="Dashboard"
                            :href="route('main.dashboard.index')"
                            @click="$emit('close_emit')"
                            :active="$page.url.startsWith('/dashboard')"
                        />
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
                        <DashNav
                            image="project"
                            nav_name="Assessments"
                            :href="route('view.assessments.index')"
                            @click="$emit('close_emit')"
                            :active="$page.url.startsWith('/history/assessments')"
                        />
                    </div>
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
        </div>
        <div
            class="max-sm:w-[30%] w-[70%] h-full cursor-pointer"
            @click="$emit('close_emit')"
        ></div>
    </div>
</template>
