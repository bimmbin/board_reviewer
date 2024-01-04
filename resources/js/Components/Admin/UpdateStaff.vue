<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const emit = defineEmits(["close_dialog"]);

const exit = ref("/img/exit.svg");
const edit_icon = ref("/img/edit.svg");
const delete_icon = ref("/img/delete.svg");

const { staff, route_name } = defineProps({
    staff: Object,
    route_name: String,
});

const form = useForm({
    user_id: staff.user_id,
    employee_number: staff.employee_number,
    first_name: staff.first_name,
    last_name: staff.last_name,
    middle_name: staff.middle_name,
});

const submit = () => {
    form.post(route(route_name + ".update", staff.id), {
        onSuccess: () => emit("close_dialog"),
    });
};
</script>

<template>
    <div
        class="w-full h-screen absolute top-0 left-0 px-10 max-md:px-5 py-5 bg-black bg-opacity-70 flex items-center justify-center cursor-default"
    >
        <div
            class="w-[900px] mx-auto max-2xl:w-[800px] max-xl:w-[700px] max-md:w-screen max-md:px-5 py-5 max-sm:py-5 text-black max-xl:px-10 bg-blue-100 rounded-xl px-5"
        >
            <!-- Dialog Content -->
            <!-- Edit header -->
            <div
                class="w-full flex flex-col justify-between items-center gap-5"
            >
                <div class="w-full flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-blue-800 capitalize">
                        Edit {{ route_name }}
                    </h1>
                    <img
                        :src="exit"
                        @click="$emit('close_dialog')"
                        class="cursor-pointer h-5"
                    />
                </div>
            </div>
            <form
                @submit.prevent="submit"
                class="mt-3 flex flex-col gap-3 border-b border-blue-300 pb-5"
            >
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

                        <InputError
                            class="mt-2"
                            :message="form.errors.last_name"
                        />
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
                <PrimaryButton class="w-full">Update</PrimaryButton>
            </form>
        </div>
    </div>
</template>
