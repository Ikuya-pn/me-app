<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue'

const props = defineProps({
    fix_works: Object,
    previous_works: Object,
    worker_id: String,
    worker: String,
})

</script>

<template>
    <Head title="シフト修正" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ worker.name }} 様のシフト修正</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <div class="md:w-2/3 mx-auto p-8 flex justify-around items-center">
                            <div>
                                <h1 class="mb-3 text-lg text-red-400">修正前</h1>
                                <div v-for="p_work in previous_works" class="mb-4">
                                    <h2 class="text-lg mt-2">{{ p_work.date }}</h2>
                                    <h3 class="text-gray-600 mt-1">{{ p_work.start_time }} ~ {{ p_work.end_time }}</h3>
                                    <h3 class="text-gray-600">休憩: {{ p_work.break_time }}分</h3>
                                    <h3 class="text-lg mt-2">合計: {{ p_work.result_time }}</h3>
                                    <div class="border"></div>
                                </div>
                            </div>
                            <div>
                                <h1 class="mb-3 text-lg text-indigo-600">申請内容</h1>
                                <div v-for="f_work in fix_works" class="mb-4">
                                    <h2 class="text-lg mt-2">{{ f_work.date }}</h2>
                                    <h3 class="text-gray-600 mt-1">{{ f_work.start_time }} ~ {{ f_work.end_time }}</h3>
                                    <h3 class="text-gray-600">休憩: {{ f_work.break_time }}分</h3>
                                    <h3 class="text-lg mt-2">合計: {{ f_work.result_time }}</h3>
                                    <div class="border"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right pb-8 w-2/3 mx-auto mt-3">
                            <Link :href="route('admin.store', {worker: worker_id})" class="bg-blue-400 hover:bg-blue-300 px-4 py-2 text-white rounded">承認する</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
