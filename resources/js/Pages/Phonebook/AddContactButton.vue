<script setup>

const emit = defineEmits(['buttonClicked']);

const buttonClicked = () => {
    emit('buttonClicked');
}
</script>

<template>
    <button 
        class="my-2 p-4 bg-gray-500 text-white hover:shadow-lg sm:rounded-lg"
        @click="buttonClicked"
    >
        Добавить
    </button>
</template>
