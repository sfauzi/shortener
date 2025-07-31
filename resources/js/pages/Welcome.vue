<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-800">
        <div class="max-w-xl p-8 bg-white dark:bg-slate-900 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">Create Short URL</h2>

            <form @submit.prevent="submit" class="space-y-4">
                <input v-model="form.original_url" type="url" placeholder="Enter your URL (e.g. https://example.com)"
                    class="input w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required />

                <input v-model="form.keyword" type="text" placeholder="Custom Keyword (e.g. my-link)"
                    class="input w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required />

                <button type="submit"
                    class="btn w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200">Shorten</button>
            </form>

            <div v-if="shortUrl" class="mt-6 text-green-600 text-center">
                Shortened URL: <a :href="shortUrl" target="_blank" class="font-bold underline">{{ shortUrl }}</a>
            </div>

            <div v-if="qrCodePath" class="mt-4 text-center">
                <img :src="qrCodePath" alt="QR Code" class="h-32 w-32 object-contain mx-auto" />
            </div>
        </div>
    </div>


</template>

<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                original_url: '',
                // title: '',
                keyword: '',
            },
            shortUrl: '',
            qrCodePath: '',
        };
    },
    methods: {
        async submit() {
            try {
                const res = await axios.post('/shorten', this.form);
                this.shortUrl = res.data.short_url;
                this.qrCodePath = res.data.qrcode_path ? `/storage/${res.data.qrcode_path}` : '';
            } catch (error) {
                alert(error.response?.data?.message || 'An error occurred');
            }
        },
    },
};
</script>
