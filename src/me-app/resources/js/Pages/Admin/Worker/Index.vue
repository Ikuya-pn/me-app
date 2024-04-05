<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    workers: Array,
})

console.log(props.workers)

</script>

<template>

    <Head title="スタッフ管理" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                スタッフ管理
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pt-6">
                        <div class="mb-8">
                            <FlashMessage />
                        </div>
                    <div class="flex items-center justify-end md:w-4/5 lg:w-2/3 w-4/5 mx-auto mb-10">
                        <div>
                            <Link :href="route('admin.worker.create')" class="bg-teal-400 hover:bg-teal-300 text-white rounded p-2 shadow-md">スタッフを登録する</Link>
                        </div>             
                    </div>
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto pb-8">
                        <table class="table-auto w-full text-left text-sm md:w-4/5 mx-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ID</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 whitespace-nowrap">氏名</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="worker in workers" :key="worker.id">
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ worker.id }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 whitespace-nowrap underline text-blue-500"><Link :href="route('admin.worker.show', {id: worker.id})">{{ worker.name }}</Link></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
