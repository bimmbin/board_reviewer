<script setup>
import { watch, ref } from "vue";

const props = defineProps({
    time_remaining: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["time_ended_submit"]);
const timer = ref("/img/timer.svg");

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
    <div
        v-if="time_remaining.invert == 0"
        class="text-xl w-12 h-12 text-center font-semibold transition ease-in-out delay-150 hover:scale-125 hover:text-red-500 translate-y-1.5 border border-gray-400 rounded-full flex items-center justify-center"
        :class="{ 'text-red-500 scale-125 border-red-200': countDown <= 10 }"
    >
        {{ countDown }}
    </div>
    <div v-else>Time ended</div>
</template>
