<script setup>
import { computed } from 'vue';


const props = defineProps({
    formValues: {
        type: Object,
        default: {
            name: '',
            phone: '',
            marked: false,
        }
    }
});

const emit = defineEmits(['formSubmit', 'closeModal']);

const formSubmit = () => {
    emit('formSubmit');
}

const closeModal = () => {
    emit('closeModal');
}

const isFormValidated = computed(() => {
    return  validateFormName() && validateFormPhone();
});

const intPhone = computed(() => {
    return  String(props.formValues.phone.replace(/\D/g, '')).length;
});

const validateFormName = () => {
    if(props.formValues.name.length && props.formValues.name.length < 255) {
        return true;
    }
    return false;
}

const validateFormPhone = () => {
    if(typeof(props.formValues.phone) === 'number' && props.formValues.phone > 0) {
        return true;
    }

    const isNoLetters = /^[^a-zA-Z]*$/.test(props.formValues.phone);
    const intValues = props.formValues.phone.replace(/\D/g, '');
    if(isNoLetters && String(intValues).length && String(intValues).length <= 11) {
        return true;
    }
    
    return false;
}

</script>

<template>
    <div 
        class="absolute bg-white p-4 rounded-md shadow-lg" style="position: fixed; "
    >
        <form class="form" @submit.prevent="formSubmit">
            <input 
                v-model="formValues.name"
                type="text" 
                class="p-1 w-full rounded-md my-1"  
                placeholder="ФИО"
            >
            <input 
                v-model="formValues.phone"
                type="text" 
                class="p-1 w-full rounded-md my-1" 
                placeholder="Телефон"
            >
            <label class="flex align-center mt-1">
                <input 
                    v-model="formValues.marked"
                    type="checkbox" 
                    class="p-1 rounded-md my-1 mr-2" 
                >
                Избранный контакт
            </label>
            <div>
                <button 
                    class="mt-2 p-2 text-white rounded-md hover:shadow-lg form-button"
                    :disabled="!isFormValidated"
                >
                    Сохранить
                </button> 
                <button 
                    class="mt-2 ml-2 p-2 text-white rounded-md hover:shadow-lg form-button"
                    @click.prevent="closeModal"
                >
                    Закрыть
                </button> 
            </div>
            
        </form>
    </div>    
</template>

<style scoped>
    .form {
        width: 300px;
    }

    .form-button {
        background-color: darkgray;
    }

    .form-button:disabled {
        background-color: #e2e2e2;
        box-shadow: none;
    }
</style>