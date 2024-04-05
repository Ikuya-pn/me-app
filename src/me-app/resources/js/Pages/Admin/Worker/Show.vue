<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    worker: Object,
    monthly_salaries: Array,
})

console.log(props.monthly_salaries)

const deleteCustomer = id => {
    if(confirm('このワーカーを完全に削除しますか？')){
        router.delete(`/admin/worker/delete/${id}`)
    }
}

</script>

<template>

    <Head title="スタッフ詳細" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ worker.name }} 様
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-10">
                    <div class="w-full md:w-2/3 mx-auto bg-gray-100 overflow-hidden shadow-lg sm:rounded-lg flex justify-around px-5">
                        <div class="py-10">
                            <p class="text-gray-600 mb-3">氏名: <span class="text-lg text-gray-800">{{ worker.name }}</span></p>
                            <p class="text-gray-600 mb-3">メールアドレス: <span class="text-lg text-gray-800">{{ worker.email }}</span></p>
                            <p class="text-gray-600 mb-3">時給: <span class="text-lg text-gray-800">¥ {{ worker.hourly_wage }}</span></p>
                        </div>
                        <div class="pt-10">
                            <Link :href="route('admin.worker.edit', {id: worker.id})" class="text-gray-600 hover:text-gray-700 underline whitespace-nowrap ml-4">編集する</Link>
                            <div class="mb-4"></div>
                            <button @click="deleteCustomer(worker.id)" class="text-gray-600 hover:text-gray-700 underline whitespace-nowrap ml-4">削除する</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="monthly_salaries && monthly_salaries.length > 0" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-10">
                <div class="relative overflow-x-auto">
                    <table class="w-2/3 mx-auto text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    勤怠月
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="salary in monthly_salaries" class="bg-white border-b">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <Link :href="route('admin.worker.salary-show', {id: salary.id})">{{ salary.year }}月 {{ salary.month }}日</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
