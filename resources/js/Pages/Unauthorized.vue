
<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const unauthorized = ref("/img/unauthorized.png");


</script>

<template>
    <div class="w-full h-screen flex justify-center items-center">
      <div class="flex flex-col items-center gap-10">
        <img :src="unauthorized" class="h-60">
        <p class="text-2xl font-semibold">Error 404 Page not found</p>
      </div>
     
    </div>
</template>
