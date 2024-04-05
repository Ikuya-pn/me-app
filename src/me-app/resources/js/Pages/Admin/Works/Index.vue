<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    works: Object,
})

console.log(props.works)

</script>

<template>

    <Head title="勤怠一覧" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               勤怠一覧
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pt-6">
                        <div class="mb-8">
                            <FlashMessage />
                        </div>
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left text-sm md:w-4/5 mx-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 whitespace-nowrap">勤怠日</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">氏名</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤怠時間</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 hidden md:block">勤務先</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="work in works.data" :key="work.id">
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ work.date }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ work.worker.name }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ work.result_time }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3 hidden md:table-cell align-top">{{ work.customer?.name ?? '未設定'  }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3"><Link :href="route('admin.works.edit', {id: work.id})" class="text-gray-600 underline">編集</Link></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination class="mt-6" :links="works.links"></Pagination>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
