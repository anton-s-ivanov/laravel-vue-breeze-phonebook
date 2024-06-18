<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AddContactButton from './AddContactButton.vue';
import ContactModal from './ContactModal.vue';
import { reactive, ref } from 'vue';
import { router } from '@inertiajs/vue3'
import {storeData, updateData, deleteData} from '@/api.js'

const props = defineProps({
    contactList: {
        type: Array,
        default: () => []
    }
})

const contactModalData = reactive({
    'shown': false,
    'mode': 'new-contact',
    'formValues': {
        id: null,
        name: '',
        phone: '',
        marked: false,
    }
});

const addContactButton = ref(null);
const contactModal = ref(null);

const addContact = () => {
    resetContactModalData();
    const modalCoordinates = getModalCoordinates(addContactButton.value.$el, 'right')
    showContactModal('new-contact', modalCoordinates);
}

const editContact = (contactListItem, target) => {
    const modalCoordinates = getModalCoordinates(target, 'left');
    showContactModal('edit-contact', modalCoordinates);
    setContactModalData(contactListItem);
}

const deleteContact = (id) => {
    deleteData('/contacts', id);
}

const closeModal = () => {
    contactModalData.shown = false;
    resetContactModalData();
}

const setContactModalData = (data) => {
    contactModalData.formValues.id = data.id;
    contactModalData.formValues.name =  data.name;
    contactModalData.formValues.phone = data.phone;
    contactModalData.formValues.marked = data.marked;
}


const resetContactModalData = () => {
    contactModalData.formValues.id = null;
    contactModalData.formValues.name = '';
    contactModalData.formValues.phone = '';
    contactModalData.formValues.marked = false;
}

const formSubmit = () => {
    if(typeof(contactModalData.formValues.phone) === 'string') {
        contactModalData.formValues.phone = contactModalData.formValues.phone.replace(/\D/g, '');
    }
    const contactId = contactModalData.formValues.id;
    if(contactId) {
        updateData('/contacts', contactId, contactModalData.formValues);
    } else {
        storeData('/contacts', contactModalData.formValues);
    }
    closeModal();
}

const getModalCoordinates = (target, position) => {
    const targetCoordinates = target.getBoundingClientRect();

    switch(position) {
        case 'right':
            return {
                top: targetCoordinates.top - 20,
                left: targetCoordinates.right + 20,
            }
        case 'left':
            const contactModalCoordinates = contactModal.value.$el.getBoundingClientRect();
            return {
                top: targetCoordinates.top - 20,
                left: targetCoordinates.left - 350,
            }
    }
}

const showContactModal = (mode, modalCoordinates) => {    
    contactModalData.shown = true;
    contactModal.value.$el.style.left = `${modalCoordinates.left}px`;
    contactModal.value.$el.style.top = `${modalCoordinates.top}px`;
    contactModal.value.$el.style.right = `${modalCoordinates.right}px`;
}

const redirectToContactPage = (id) => {
    router.visit('/contacts/' + id);
}

</script>

<template>
    <Head title="Список контактов" />

    <AuthenticatedLayout @click="closeModal">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Список контактов</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <add-contact-button 
                    ref="addContactButton"
                    @button-clicked="addContact"
                    @click.stop
                />

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">

                    
                    <div class="contacts-list">
                        <div class="contacts-list-item header-item">Избранный</div>
                        <div class="contacts-list-item header-item">Телефон</div>
                        <div class="contacts-list-item header-item">ФИО</div>
                        <div class="contacts-list-item header-item">Действия</div>
                        <template
                            v-for="contactListItem in contactList"
                            :key="contactListItem.id"
                            
                        >
                            <div class="contacts-list-item" :class="{'contacts-list-item-favorite': contactListItem.marked}">
                                <input :checked="contactListItem.marked" type="checkbox">
                            </div>
                            <div 
                                class="contacts-list-item redirect-cell" 
                                :class="{'contacts-list-item-favorite': contactListItem.marked}"
                                @click="redirectToContactPage(contactListItem.id)"
                            >
                                {{ contactListItem.phone }}
                            </div>
                            <div 
                                class="contacts-list-item redirect-cell"  
                                :class="{'contacts-list-item-favorite': contactListItem.marked}"
                                @click="redirectToContactPage(contactListItem.id)"
                            >
                                {{ contactListItem.name }}
                            </div>
                            <div class="contacts-list-item" :class="{'contacts-list-item-favorite': contactListItem.marked}">
                                <button 
                                    class="contact-edit-button shadow-sm sm:rounded-lg p-1 mr-1"
                                    @click.stop="editContact(contactListItem, $event.target)"
                                >
                                    Редактировать
                                </button>
                                <button 
                                    class="contact-delete-button shadow-sm sm:rounded-lg p-1"
                                    @click.stop="deleteContact(contactListItem.id)"
                                >
                                    Удалить
                                </button>
                            </div>

                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>    

    <Teleport to="body">
        <contact-modal 
            v-show="contactModalData.shown"
            ref="contactModal"
            :formValues="contactModalData.formValues"
            @form-submit="formSubmit"
            @close-modal="closeModal"
            @click.stop
        />
    </Teleport>
</template>

<style scoped>
    .contacts-list {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10;
    }

    .contacts-list-item {
        padding: 10px;
    }
    .header-item {
        font-weight: 600;
    }
    .contact-edit-button{
        background-color: #aeaec8;;
        color: white;
    }

    .contact-delete-button{
        background-color: #cdb7d0;
        color: white;
    }
    .contacts-list-item-favorite {
        background-color: #ececec;
    }

    .redirect-cell:hover {
        cursor: pointer;
        text-decoration: underline;
    }
</style>
