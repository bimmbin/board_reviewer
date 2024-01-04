<script setup>
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const { route_name } = defineProps({
    route_name: String,
});

const emit = defineEmits(["close_emit"]);

const form = useForm({
    employee_number: "",
    first_name: "",
    last_name: "",
    middle_name: "",
});

const submit = () => {
    form.post(route(route_name + ".store"), {
        onSuccess: () => emit("close_emit"),
    });
};
</script>

<template>
    <div class="mt-5">
        <h1 class="text-xl font-semibold text-blue-800 max-md:mb-2 capitalize">
            Create {{ route_name }} Account
        </h1>
        <form @submit.prevent="submit" class="mt-3 flex flex-col gap-3 pb-5">
            <div class="flex gap-3">
                <div class="flex-1">
                    <InputLabel for="employee_number" value="Employee ID" />

                    <TextInput
                        id="employee_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.employee_number"
                        required
                        autofocus
                        autocomplete="employee_number"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.employee_number"
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
            <div class="flex gap-3">
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
