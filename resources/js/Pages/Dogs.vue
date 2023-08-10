<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    url: {
        type: String,
    },
});
</script>

<template>
    <Head title="Dogs" />
            <div  class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <h2 class="font-semibold text-xl text-dark-800 text-gray-200 leading-tight place-content-center">Some doggos for you</h2>
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="container">
                    <img class=" object-none bg-black-300 w-500 h-500 object-top" :src="url" alt="">
                </div>
            </div>
        </div>
</template>
