<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const chcc_logo = ref("/img/chcc_logo.png");
const login_icon = ref("/img/login_icon.png");
const chcc_bg = ref("/img/chcc_bg.png");
</script>

<template>
    <div class="flex absolute w-full top-0 left-0">
        <div class="relative bg-chcc_bg w-full h-screen max-xl:hidden">
            <div
                class="absolute top-0 left-0 w-full h-full bg-blue-600 bg-opacity-90 text-white bg-cover hidden xl:flex flex-col items-center px-[62px] pt-[73px] gap-[20px] 2xl:justify-center 2xl:pt-0"
            >
                <img class="xl:w-[350px]" :src="chcc_logo" alt="CHCC-Logo" />

                <h1 class="font-semibold text-[25px]">
                    Interactive Licensure Exam Reviewer
                </h1>

                <p class="text-[17px] text-center">
                    Get ready to ace your licensure exams with our Interactive
                    Licensure Exam Reviewer! Specifically designed for the
                    School of Teacher Education at Concepcion Holy Cross
                    College, Inc., this dynamic system offers an engaging
                    platform to empower aspiring educators. Dive into targeted
                    content, explore user-friendly features, and supercharge
                    your exam preparation for success in the world of teaching
                </p>
            </div>
        </div>

        <div
            class="bg-white w-full h-screen relative items-center flex flex-col xl:justify-center "
        >
            <div class="w-full h-20 bg-blue-500 xl:hidden"></div>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="pb-10">
                <div
                    class="flex justify-center mt-[60px] xl:mt-[1px] xl:w-[352px] xl:justify-start"
                >
                    <img class="w-14" :src="login_icon" alt="Flash-Vector" />
                </div>

                <div class="sm:w-[352px] sm:text-left">
                    <h2
                        class="font-semibold text-[22px] text-center mt-[19px] sm:text-[25px] xl:text-[27px] xl:text-left"
                    >
                        Login
                    </h2>
                    <p
                        class="text-[12px] font-medium text-center mt-[8px] text-grayish sm:text-[13px] xl:text-[14px] xl:font-thin xl:text-left"
                    >
                        Please log in using your username and password.
                    </p>
                </div>

                <form @submit.prevent="submit" class="mt-10">
                    <div>
                        <InputLabel for="username" value="Username" />

                        <TextInput
                            id="username"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.username"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.username"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="w-full">
                        <!-- <Link :href="route('category.index')" class="mt-3 w-full inline-flex justify-center items-center px-4 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Login
                      </Link> -->
                        <PrimaryButton
                            class="w-full mt-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <div class="w-full h-full bg-blue-500 xl:hidden">
                <div
                    class="w-full h-full flex flex-col items-center gap-10 py-10 text-white"
                >
                    <img
                        class="xl:w-[350px]"
                        :src="chcc_logo"
                        alt="CHCC-Logo"
                    />

                    <h1 class="font-semibold text-[25px] max-md:text-xl">
                        Interactive Licensure Exam Reviewer
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <Head title="Log in" />
</template>
