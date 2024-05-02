<script setup>
import { watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import ElementDetails from "@/Components/ElementDetails.vue";

const emit = defineEmits(["close_dialog"]);

const { category_id, pdf, status } = defineProps({
    category_id: String,
    pdf: String,
    status: String,
});

const form = useForm({
    category_id: category_id,
    file: null,
});

watch(
    () => form.file,
    (newValue) => {
        if (newValue !== null) {
            // Perform your desired action here
            form.post(
                route("instructor.pdf.store"),
                {
                    onSuccess: () => {
                        emit("close_emit");
                        form.reset();
                        Swal.fire({
                            title: "PDF successfully uploaded",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    onError: (error) => {
                        Swal.fire({
                            title: error.file,
                            icon: "error",
                        });
                    },
                },
                {
                    preserveState: false,
                }
            );
        }
    }
);

function view_pdf() {
    router.get(route("instructor.pdf.show", { category_id: category_id }));
}
const baseUrl = window.location.origin + "/storage/" + pdf;
</script>

<template>
    <!-- <a :href="baseUrl">asdfsadfsd</a> -->

    <form
        v-if="!pdf && status === 'pending'"
        class="flex items-center justify-between py-3 max-md:px-3 max-md:py-2 max-md:text-sm max-md:flex-col max-md:items-start max-md:gap-3 bg-opacity-80"
    >
        <div class="flex items-center gap-5">
            <label
                :for="category_id"
                :class="{ hidden: form.progress }"
                class="px-2 py-1 text-sm text-white rounded cursor-pointer select-none bg-main_bg whitespace-nowrap hover:bg-blue-400"
            >
                <input
                    type="file"
                    :id="category_id"
                    @input="form.file = $event.target.files[0]"
                    class="hidden"
                />
                Upload
            </label>
        </div>
    </form>
    <div v-else>
        <ElementDetails v-if="pdf" details="View PDF">
            <a :href="baseUrl" target="_blank" rel="noopener noreferrer">
                <div
                    class="p-2 bg-blue-100 rounded-md cursor-pointer select-none hover:bg-blue-200 active:bg-blue-100"
                >
                    <img src="/img/view.svg" alt="" class="h-5" />
                </div>
            </a>
        </ElementDetails>
        <div v-else>N/A</div>
    </div>
</template>
