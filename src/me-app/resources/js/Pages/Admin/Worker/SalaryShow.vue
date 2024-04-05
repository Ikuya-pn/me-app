<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    monthly_salary: Object,
    result: String,
    worker: String,
})

console.log(props.monthly_salary)

</script>

<template>

    <Head title="給与" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ worker }} 様 
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" mx-auto overflow-hidden shadow-lg sm:rounded-lg flex justify-around">
                        

                        <div class="relative overflow-x-auto py-10">
                            <h3 class="border-b-2 border-blue-200 mb-2 inline-block ">{{ monthly_salary.year }}年 {{ monthly_salary.month }}月分</h3>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            支給額
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            出勤日数
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            勤怠時間
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-gray-50 border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            ¥ {{ monthly_salary.salary }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ monthly_salary.days }}日
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ result }}
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
