<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/vue3'

defineProps({
    customers: Object,
})

const search = ref('')

const searchCustomers = () => {
  router.get('/admin/customer', { search: search.value })
}

</script>

<template>

    <Head title="顧客管理" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客管理
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pt-6">
                        <div class="mb-8">
                            <FlashMessage />
                        </div>
                    <div class="md:flex justify-between items-center md:w-4/5 lg:w-2/3 w-4/5 mx-auto mb-10">
                        <div>
                            <Link :href="route('admin.customer.create')" class="bg-teal-400 hover:bg-teal-300 text-white rounded p-2 shadow-md">顧客を登録する</Link>
                        </div>     
                        <div class="mt-8 md:m-0">
                            <input name="search" v-model="search" type="text" class="rounded mr-3">
                            <button @click="searchCustomers" type="button" class="text-sm bg-blue-400 hover:bg-blue-300 text-white py-2 px-2 rounded">検索する</button>
                        </div>              
                    </div>
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left text-sm md:w-4/5 mx-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 whitespace-nowrap">氏名</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">電話番号</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">住所</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in customers.data" :key="customer.id">
                                    <td class="border-b-2 border-gray-200 px-4 py-3 whitespace-nowrap underline text-blue-500"><Link :href="route('admin.customer.show', {id: customer.id})">{{ customer.name }}</Link></td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ customer.phone }}</td>
                                    <td class="border-b-2 border-gray-200 px-4 py-3">{{ customer.address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination class="mt-6" :links="customers.links"></Pagination>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
