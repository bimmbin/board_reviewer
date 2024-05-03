<script setup>
import { watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import ElementDetails from "@/Components/ElementDetails.vue";

const emit = defineEmits(["close_dialog"]);

const { category_id, extra_name } = defineProps({
    category_id: String,
    extra_name: String,
});

const form = useForm({
    category_id: category_id,
    extra_name: extra_name,
});

let route_extra = "";
if (extra_name == "pdf") {
    route_extra = route("instructor.delete.pdf");
} else {
    route_extra = route("instructor.delete.embed");
}

function submit() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(
                route_extra,
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
                },
                {
                    preserveState: false,
                }
            );
        }
    });
}
</script>

<template>
    <!-- <a :href="baseUrl">asdfsadfsd</a> -->
    <ElementDetails :details="'Delete ' + extra_name">
        <div
            @click="submit"
            class="p-2 px-3 bg-red-100 rounded-md cursor-pointer select-none hover:bg-blue-200 active:bg-blue-100"
        >
            <img src="/img/delete.svg" alt="" class="h-5" />
        </div>
    </ElementDetails>
</template>
