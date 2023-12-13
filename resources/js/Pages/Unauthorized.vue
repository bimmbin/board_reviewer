
<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const unauthorized = ref("/img/unauthorized.png");

const getback = () => {
    window.history.back();
};
</script>

<template>
    <div class="w-full h-screen flex justify-center items-center">
      <div class="flex flex-col items-center gap-10">
        <img :src="unauthorized" class="h-60">
        <p class="text-2xl font-semibold">Error 404 Page not found</p>
        <a href="#" @click="getback()" class="bg-blue-500 rounded-md px-5 py-3 text-white font-semibold text-2xl">Get back</a>
      </div>
     
    </div>
</template>
