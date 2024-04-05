<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, computed, } from 'vue'

defineProps({
    customer: Object,
})

const deleteCustomer = id => {
    if(confirm('この顧客を完全に削除しますか？')){
        router.delete(`/admin/customer/delete/${id}`)
    }
}

</script>

<template>

    <Head title="顧客詳細" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客詳細
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-10">
                    <div class="w-2/3 mx-auto bg-white overflow-hidden shadow-lg sm:rounded-lg flex justify-around px-5">
                        <div class="py-10 ">
                            <p class="text-gray-600 mb-3">氏名: <span class="text-lg text-gray-800">{{ customer.name }}</span></p>
                            <p class="text-gray-600 mb-3">電話番号: <span class="text-lg text-gray-800">{{ customer.phone }}</span></p>
                            <p class="text-gray-600 mb-3">郵便番号: <span class="text-lg text-gray-800">{{ customer.postcode }}</span></p>
                            <p class="text-gray-600 mb-3">住所: <span class="text-lg text-gray-800">{{ customer.address }}</span></p>
                            <p class="text-gray-600 mb-3">備考: <span class="text-lg text-gray-800">{{ customer.memo }}</span></p>
                        </div>
                        <div class="pt-10">
                            <Link :href="route('admin.customer.edit', {id: customer.id})" class="text-gray-600 hover:text-gray-700 underline whitespace-nowrap ml-4">編集する</Link>
                            <div class="mb-4"></div>
                            <button @click="deleteCustomer(customer.id)" class="text-gray-600 hover:text-gray-700 underline whitespace-nowrap ml-4">削除する</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
