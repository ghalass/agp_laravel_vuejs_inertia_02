<template>
    <ul class="pagination pagination-sm justify-content-center my-2">
        <li class="page-item" :class="{ 'disabled': props.prev == null }">
            <Link class="page-link" :href="props.prev" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            </Link>
        </li>
        <li v-for="link in computedLinks" class="page-item" :class="{ 'active': link.active }" :key="link.url">
            <Link class="page-link" :href="link.url">{{ link.label }}</Link>
        </li>
        <li class="page-item" :class="{ 'disabled': props.next == null }">
            <Link class="page-link" :href="props.next" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </Link>
        </li>
    </ul>
</template>

<script setup>
import { computed } from 'vue';

const computedLinks = computed(() => {
    props.links.shift(); // remove the first element in the array
    props.links.pop();// remove the last element in the array
    return props.links;
})

const props = defineProps({
    links: {
        type: Array,
        required: true
    },
    prev: {
        type: String,
        default: ""
    },
    next: {
        type: String,
        default: ""
    }
})

</script>
