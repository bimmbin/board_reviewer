<script setup>
import { onMounted } from "vue";

defineProps({
    message: {
        type: String,
    },
    color: {
        type: String,
    },
    is_array: {
        type: Boolean,
    },
});

const emit = defineEmits(["close_flash"]);

onMounted(() => {
    setTimeout(() => {
        emit("close_flash");
    }, 5000);
});
</script>

<template>
    <div
        v-if="is_array"
        class="w-full py-2 px-3 rounded-md mt-2 flex flex-col items-center gap-2 justify-center text-start text-[14px] text-white"
        :class="{
            'bg-green-500 ': color == 'green',
            'bg-yellow-500 ': color == 'yellow',
            'bg-red-500 ': color == 'red',
        }"
    >
        <div v-for="main_message in message">{{ main_message }}</div>
    </div>

    <div
        v-else
        class="w-full py-2 px-3 rounded-md mt-2 flex items-center justify-center text-[14px] text-center text-white"
        :class="{
            'bg-green-500 ': color == 'green',
            'bg-yellow-500 ': color == 'yellow',
        }"
    >
        {{ message }}
    </div>
</template>
