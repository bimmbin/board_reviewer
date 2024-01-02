<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1 gap-1 mt-2">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class=" px-4 py-3  text-sm leading-4 border border-blue-300 text-blue-800 rounded max-md:px-3 max-md:py-2 opacity-30" v-html="link.label" />
        <Link v-else :key="`link-${key}`" class="px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-blue-300 border border-blue-300 focus:border-indigo-500 rounded bg-white text-blue-800 max-md:px-3 max-md:py-2" :class="{ '!bg-blue-500 text-white': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    Link,
  },
  props: {
    links: Array,
  },
}
</script>