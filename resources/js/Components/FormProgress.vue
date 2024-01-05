<script setup>
import { watch, ref } from "vue";

defineProps({
    percent: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="w-full bg-white flex items-center justify-start rounded-md">
        <div
            class="m-1 bg-blue-600 text-white text-center rounded transition-all"
            :style="'width:' + percent + '%'"
        >
            {{ percent }}%
        </div>
    </div>
</template>
