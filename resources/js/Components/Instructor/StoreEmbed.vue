<script setup>
import { watch } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import ElementDetails from "@/Components/ElementDetails.vue";

const emit = defineEmits(["close_dialog"]);
const page = usePage();

const { category_id, embed, status } = defineProps({
    category_id: String,
    embed: String,
    status: String,
});

const form = useForm({
    category_id: category_id,
    embed: null,
});

function submit() {
    form.post(
        route("instructor.embed.store"),
        {
            onSuccess: () => {
                emit("close_emit");
                form.reset();
                Swal.fire({
                    title: "The link successfully embedded.",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.reload();
                });
            },
            onError: (error) => {
                Swal.fire({
                    title: error.embed,
                    icon: "error",
                });
            },
        },
        {
            preserveState: false,
        }
    );
}
function view_embed() {
    Swal.fire({
        html: embed,
        customClass: "w-fit h-fit",
        showConfirmButton: false,
    });
}

const role = page.props.auth.user.user_role;
</script>

<template>
    <!-- <a :href="baseUrl">asdfsadfsd</a> -->

    <form
        @submit.prevent="submit"
        v-if="!embed && status === 'pending' && role === 'instructor'"
        class="flex flex-col gap-1 py-3 max-md:px-3 max-md:py-2 max-md:text-sm max-md:flex-col max-md:items-start max-md:gap-3 bg-opacity-80"
    >
        <textarea
            v-model="form.embed"
            cols="30"
            rows="2"
            class="text-sm border rounded border-main_bg"
        ></textarea>
        <button
            class="px-2 py-1 text-sm text-white rounded cursor-pointer select-none bg-main_bg whitespace-nowrap hover:bg-blue-400"
        >
            Submit
        </button>
    </form>
    <div v-else>
        <ElementDetails v-if="embed" details="View Embedded Video">
            <div
                @click="view_embed"
                class="p-2 bg-blue-100 rounded-md cursor-pointer select-none hover:bg-blue-200 active:bg-blue-100"
            >
                <img src="/img/view.svg" alt="" class="h-5" />
            </div>
        </ElementDetails>
        <div v-else>N/A</div>
    </div>
</template>
