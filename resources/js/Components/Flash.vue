<script setup>
import { onMounted } from "vue";

defineProps({
    message: {
        type: String,
    },
    color: {
        type: String,
    },
});

const emit = defineEmits(["close_flash"]);

onMounted(() => {
    setTimeout(() => {
        emit('close_flash');
    }, 5000);
});
</script>

<template>
    <div
        class="w-full py-2 px-3 rounded-md mt-2 flex items-center justify-center text-[14px] text-center text-white"
        :class="{
            'bg-green-500 ': color == 'green',
            'bg-yellow-500 ': color == 'yellow',
        }"
    >
        {{ message }}
    </div>
</template>
