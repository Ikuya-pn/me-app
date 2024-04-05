<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    workers_with_names: Array,
    fix_works_count: Number,
})


</script>

<template>
    <Head title="管理者トップ" />

    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-8">
                    <div v-if="fix_works_count" class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <div class="w-2/3 mx-auto pb-8">
                            <h2 class="mt-8 mb-5 bg-orange-300 text-white px-3 py-2 rounded text-center">
                                {{ fix_works_count }}件のシフト修正申請があります。
                            </h2>
                            <div v-for="worker in workers_with_names">
                                <span>・</span><Link :href="route('admin.show', {worker: worker.id})" class="text-lg text-blue-500 hover:text-blue-400">{{worker.name}}</Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-2/3 mx-auto py-6">
                        <h2 class="text-xl text-gray-700 border-y bg-gray-100 py-3 pl-3">メニュー</h2>
                        <Link :href="route('admin.customer.index')" class="pl-3 py-3 block text-sm border-b text-blue-500">顧客管理</Link>
                        <Link :href="route('admin.worker.index')" class="pl-3 py-3 block text-sm border-b text-blue-500">スタッフ管理</Link>
                        <Link :href="route('admin.works.index')" class="pl-3 py-3 block text-sm border-b text-blue-500">勤怠一覧</Link>   
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
