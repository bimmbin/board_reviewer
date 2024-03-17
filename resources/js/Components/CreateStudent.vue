<script setup>
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const { major_id } = defineProps({
    major_id: String,
});

const emit = defineEmits(["close_emit"]);

const form = useForm({
    major_id: major_id,
    student_number: "",
    first_name: "",
    last_name: "",
    middle_name: "",
});

const submit = () => {
    form.post(route("students.store"), {
         onSuccess: () => {
            emit("close_emit");
            form.reset();
        }
    });
};
</script>

<template>
    <div class="flex-1 pt-5 max-lg:pt-0">
        <h1 class="text-xl font-semibold text-blue-800 max-md:mb-2">
            Create manually
        </h1>
        <form @submit.prevent="submit" class="mt-3 flex flex-col gap-3 pb-5">
            <div class="flex flex-col gap-3">
                <div class="flex-1">
                    <InputLabel for="student_number" value="Student ID" />

                    <TextInput
                        id="student_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.student_number"
                        required
                        autofocus
                        autocomplete="student_number"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.student_number"
                    />
                </div>
                <div class="flex-1">
                    <InputLabel for="first_name" value="First Name" />

                    <TextInput
                        id="first_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.first_name"
                        required
                        autofocus
                        autocomplete="first_name"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.first_name"
                    />
                </div>
            </div>

            <!-- second row  -->
            <div class="flex flex-col gap-3">
                <div class="flex-1">
                    <InputLabel for="last_name" value="Last Name" />

                    <TextInput
                        id="last_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.last_name"
                        required
                        autofocus
                        autocomplete="last_name"
                    />

                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
                <div class="flex-1">
                    <InputLabel for="middle_name" value="Middle Name" />

                    <TextInput
                        id="middle_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.middle_name"
                        required
                        autofocus
                        autocomplete="middle_name"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.middle_name"
                    />
                </div>
            </div>
            <PrimaryButton class="w-full">Create Account</PrimaryButton>
        </form>
    </div>
</template>
