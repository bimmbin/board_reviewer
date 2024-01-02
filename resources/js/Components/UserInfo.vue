<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";


</script>

<template>
    <div class="flex flex-col items-center gap-1 text-center">
      <h1 class="capitalize text-white font-light text-lg border-b border-blue-300 px-2 mx-2 py-1">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}</h1>
      <span class="capitalize text-white opacity-70 font-extralight text-md">{{ $page.props.auth.user.user_role }}</span>
    </div>
</template>
