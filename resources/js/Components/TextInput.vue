<template>
    <div class="form-group mb-3">
        <label>{{ name }}</label>
        <input v-model="model" :class="{ 'is-invalid': message }" class="form-control form-control-sm" :type="type" />
        <span v-if="message" class="invalid-feedback error fst-italic">
            {{ message }}
        </span>
    </div>
</template>

<script setup>

defineProps({
    name: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    message: String
})

const model = defineModel({
    type: null,
    required: true
})

</script>
