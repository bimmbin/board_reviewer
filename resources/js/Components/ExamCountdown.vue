<script setup>
import { watch, ref } from "vue";

const props = defineProps({
    time_remaining: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["time_ended_submit"]);

let countDown = ref(props.time_remaining.s);

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
        emit("time_ended_submit");
    }
});
</script>

<template>
    <div v-if="time_remaining.invert == 0">
        {{ countDown }}
    </div>
    <div v-else>Time ended</div>
</template>
