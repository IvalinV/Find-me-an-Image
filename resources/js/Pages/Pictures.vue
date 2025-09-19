<script setup>
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";
import { useClipboard } from '@vueuse/core'

defineProps({
    url: {
        type: String,
    }
});

const source = ref('Hello')
const { text, copy, copied, isSupported } = useClipboard({ source })

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

async function downloadImage(){
    isLoading.value = true

    const response = await axios.post("/api/pictures/download", {
        url: picture.value.url,
    }, {
        contentType: "blob"
    });

    console.log(response)

    const blob = new Blob([response.data], {
        type: 'image/png'
    })

    const link = document.createElement('a')
    link.href = window.URL.createObjectURL(blob)
    link.download = 'image'
    link.click()

    isLoading.value = false
}
</script>

<template>
    <Head title="Dogs" />
            <div class="flex flex-col sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                <h1 class="font-bold py-4 text-[2rem] text-dark-800 text-gray-200 leading-tight place-content-center">Find the image size you need</h1>
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-center">
                        <input v-model="width" type="number" class="bg-gray-100 mb-2 mt-2 text-gray-900 dark:bg-gray-800 dark:text-gray-100 rounded-lg">
                        <input v-model="height" type="number" class="bg-gray-100 mt-4 mb-4 text-gray-900 dark:bg-gray-800 dark:text-gray-100 rounded-lg">
                    </div>
                    <div v-if="picture" class="flex justify-center w-full overflow-hidden max-w-2xl max-h-2xl">
                        <img class="rounded-lg object-cover object-top overflow-hidden" :src="picture.url" alt="">
                    </div>
                    <div class="flex flex-row py-4 justify-center content-center">
                        <button
                            v-if="!isLoading"
                            class="rounded-lg dark:bg-gray-800 border px-4 py-2 dark:text-gray-100 bg-gray-100 text-gray-900"
                            @click="getImage"
                        >
                            Fetch
                        </button>
                        <template v-else>
                            <div role="status">
                                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </template>
                    </div>

                    <div class="dark:text-gray-100 flex flex-row py-2 justify-center content-center">
                        <div v-if="isSupported && picture">
                            <button
                                class="rounded-lg dark:bg-gray-800 border px-4 py-2 dark:text-gray-100 bg-gray-100 text-gray-900"
                                @click='copy(picture.url)'>
                                <!-- by default, `copied` will be reset in 1.5s -->
                                <span v-if='!copied'>Copy URL</span>
                                <span v-else>Copied!</span>
                            </button>
                        </div>
                    </div>
            </div>
        </div>
</template>
