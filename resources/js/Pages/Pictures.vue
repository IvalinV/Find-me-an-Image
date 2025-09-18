<script setup>
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    url: {
        type: String,
    }
});

const width = ref('')
const height = ref('')
const picture = ref(null)
const isLoading = ref(false)
async function getImage(){
    isLoading.value = true

    const response = await axios.post("/api/pictures/get", {
        width: width.value,
        height: height.value
    });

    isLoading.value = false

    picture.value = response.data.picture
}
</script>

<template>
    <Head title="Dogs" />
            <div class="relative flex flex-col sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <h4 class="font-bold text-xl text-dark-800 text-gray-200 leading-tight place-content-center">Find the image you need</h4>
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-center">
                    <input v-model="width" type="number" class="bg-gray-100 mb-2 mt-2 text-gray-900 dark:bg-gray-800 dark:text-gray-100 rounded-lg">
                    <input v-model="height" type="number" class="bg-gray-100 mt-4 mb-4 text-gray-900 dark:bg-gray-800 dark:text-gray-100 rounded-lg">
                </div>
                <div v-if="picture" class="w-52 h-52 overflow-hidden max-w-2xl max-h-2xl">
                    <img class="rounded-lg object-cover object-top overflow-hidden" :src="picture.url" alt="">
                </div>
                <div class="flex flex-row py-4 justify-center content-center">
                    <button
                        class="rounded-lg dark:bg-gray-800 border px-4 py-2 dark:text-gray-100 bg-gray-100 text-gray-900"
                        :disabled="isLoading"
                        @click="getImage"
                    >
                        Fetch
                    </button>
                </div>
            </div>
        </div>
</template>
