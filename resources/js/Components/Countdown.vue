<script setup>
import { watch, ref } from "vue";

const props = defineProps({
    time: {
        type: Number,
        required: true,
    },
    time_ended: {
        type: Boolean,
        required: true,
    },
});

let countDown = ref(props.time);

function countDownTimer() {
    if (countDown.value > 0) {
        setTimeout(() => {
            countDown.value -= 1;
            countDownTimer();
        }, 1000);
    }
}
countDownTimer();
watch(countDown, (new_countDown) => {
    if (new_countDown == 0) {
        console.log("do this");
    }
});
</script>

<template>
    <div v-if="time_ended">
    {{ countDown }}
    </div>
</template>
