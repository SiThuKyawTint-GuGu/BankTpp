<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
    modelValue: {
        type: String
    }
});

// defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <v-text-field variant="outlined" :disabled="disabled" density="compact" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input"></v-text-field>
</template>
