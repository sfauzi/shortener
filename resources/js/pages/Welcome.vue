<template>
    <div class="max-w-xl mx-auto p-6 bg-white dark:bg-slate-900 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Create Short URL</h2>
        <form @submit.prevent="submit">
            <input v-model="form.original_url" type="url" placeholder="https://example.com" class="input" required />
            <!-- <input v-model="form.title" type="text" placeholder="Custom Title (optional)" class="input mt-2" /> -->
            <input v-model="form.keyword" type="text" placeholder="Custom Keyword (e.g. my-link)" class="input mt-2"
                required />
            <button type="submit" class="btn mt-4">Shorten</button>
        </form>

        <div v-if="shortUrl" class="mt-4 text-green-600">
            Shortened URL: <a :href="shortUrl" target="_blank">{{ shortUrl }}</a>
        </div>

        <div v-if="qrCodePath" class="mt-2">
    <img :src="qrCodePath" alt="QR Code" class="h-32 w-32 object-contain" />
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
