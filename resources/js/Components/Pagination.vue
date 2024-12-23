<template>
    <div class="d-flex align-items-center justify-content-between">
        <ul class="pagination pagination-sm my-2">

            <li class="page-item" :class="{ 'disabled': props.paginator.prev == null }">
                <Link class="page-link" :href="props.paginator.prev" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </Link>
            </li>

            <li v-for="link in computedLinks" class="page-item" :class="{ 'active': link.active }" :key="link.url">
                <Link class="page-link" :href="link.url">{{ link.label }}</Link>
            </li>

            <li class="page-item" :class="{ 'disabled': props.paginator.next == null }">
                <Link class="page-link" :href="props.paginator.next" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </Link>
            </li>
        </ul>
        <p class="my-0">Affiche {{ props.paginator.from }} à {{ props.paginator.to }} du {{ props.paginator.total }}
            résultats</p>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const computedLinks = computed(() => {
    props.paginator.links.shift(); // remove the first element in the array
    props.paginator.links.pop();// remove the last element in the array
    return props.paginator.links;
})

const props = defineProps({
    paginator: {
        type: Object,
        required: true
    }
})

</script>
