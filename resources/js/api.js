import { router } from '@inertiajs/vue3';

export const storeData = (url, data) => {
    try {
        router.post(url, data)
    } catch (error) {
        console.error(error);
    }
}

export const updateData = (url, id, data) => {
    try {
        router.put(`${url}/${id}`, data)
    } catch (error) {
        console.error(error);
    }
}

export const deleteData = (url, id) => {
    try {
        router.delete(`${url}/${id}`)
    } catch (error) {
        console.error(error);
    }
}