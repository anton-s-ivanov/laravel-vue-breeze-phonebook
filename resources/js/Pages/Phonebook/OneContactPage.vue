<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps(['contactData']);

</script>


<template>
    <Head title="Информация о контакте" />

    <AuthenticatedLayout @click="closeModal">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Информация о контакте</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ul>
                    <li>ФИО: {{contactData.data.name}}</li>
                    <li>Телефон: {{contactData.data.phone}}</li>
                    <li v-if="contactData.data.marked">Избранный контакт</li>
                </ul>       
            </div>
        </div>
    </AuthenticatedLayout>    


</template>

<style scoped>

</style>
