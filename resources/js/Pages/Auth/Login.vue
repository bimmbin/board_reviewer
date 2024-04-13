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
    student: {
        type: Object,
    },
    instructor: {
        type: Object,
    },
    dean: {
        type: Object,
    },
    admin: {
        type: Object,
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
    <div class="absolute top-0 left-0 flex w-full">
        <div class="relative w-full h-screen bg-chcc_bg max-xl:hidden">
            <div
                class="absolute top-0 left-0 w-full h-full bg-main_bg bg-opacity-90 text-white bg-cover hidden xl:flex flex-col items-center px-[62px] pt-[10px] gap-5 2xl:justify-center 2xl:pt-0"
            >
                <img
                    class="w-[250px] max-2xl:w-60 max-sm:w"
                    :src="chcc_logo"
                    alt="CHCC-Logo"
                />

                <h1 class="font-semibold text-[25px] pb-14 max-2xl:pb-5">
                    Interactive Licensure Exam Reviewer
                </h1>

                <div class="flex justify-between gap-10">
                    <div class="flex flex-col items-center gap-1">
                        <h1 class="text-2xl font-bold text-white">Mission</h1>
                        <p class="text-[17px] text-center max-2xl:text-base">
                            Concepcion Holy Cross College is an institution for
                            academic and values formation offering relevant,
                            learner-centered and values-oriented programs that
                            produces competent persons of character in the
                            service of society
                        </p>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <h1 class="text-2xl font-bold text-white">Vision</h1>

                        <p class="text-[17px] text-center max-2xl:text-base">
                            To become a God-centered learning institution,
                            focused on holistic education that form and educates
                            individuals, to become conscious, competent,
                            compassionate, and committed person towards the
                            development of a just and humane society
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="relative flex flex-col items-center w-full h-screen bg-white xl:justify-center"
        >
            <div class="w-full h-20 bg-main_bg xl:hidden"></div>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <div class="pb-10">
                <div
                    class="flex justify-center mt-[60px] xl:mt-[1px] xl:w-[352px] xl:justify-start"
                >
                    <img class="w-14" :src="login_icon" />
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
                            class="block w-full mt-1"
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
                            class="block w-full mt-1"
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
                        <!-- <Link :href="route('category.index')" class="inline-flex items-center justify-center w-full px-4 py-3 mt-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-md bg-main_bg hover:bg-blue-400 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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

            <div class="order-last w-full h-full mt-5 bg-main_bg xl:hidden">
                <div
                    class="flex flex-col items-center w-full h-full gap-10 py-10 text-white"
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
            <!-- <div class="flex flex-col flex-wrap gap-3">
                <span class="font-semibold">For testing purposes</span>
                <div class="flex flex-col flex-1 border-t border-blue-300">
                    <span class="font-semibold">Student</span>
                    <span>Username: {{ student.username }}</span>
                    <span
                        >Password:
                        {{ student.student_profile.student_number }}</span
                    >
                </div>

                <div class="flex flex-col border-t border-blue-300">
                    <span class="font-semibold">Instructor</span>
                    <span>Username: {{ instructor.username }}</span>
                    <span
                        >Password:
                        {{ instructor.staff_profile.employee_number }}</span
                    >
                </div>

                <div class="flex flex-col border-t border-blue-300">
                    <span class="font-semibold">Dean</span>
                    <span>Username: {{ dean.username }}</span>
                    <span
                        >Password:
                        {{ dean.staff_profile.employee_number }}</span
                    >
                </div>

                <div class="flex flex-col border-t border-blue-300">
                    <span class="font-semibold">Admin</span>
                    <span>Username: {{ admin.username }}</span>
                    <span>Password: admin123</span>
                </div>
            </div> -->
        </div>
    </div>

    <Head title="Log in" />
</template>
