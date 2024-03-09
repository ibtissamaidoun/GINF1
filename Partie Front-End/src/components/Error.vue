<script setup>

const props = defineProps({
    errors: {required: false}
})

</script>

<template>
    <div class="text-red-500 text-sm">
        <div v-if="typeof errors === 'string'">{{ errors }}</div>
        <div v-else v-for="(error, index) in errors" :key="index">{{ error }}</div>
    </div>
</template>