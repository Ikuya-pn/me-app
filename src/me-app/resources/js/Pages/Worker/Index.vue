<script setup>
import WorkerLayout from '@/Layouts/WorkerLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, computed } from 'vue'
import dayjs from 'dayjs'
// 月末の日にち
const endDate = dayjs().endOf('month').get('date')
// 月初の曜日
const startWeekday = dayjs().startOf('month').get('day')
//　配列を作ります。
const dates = computed(() => {
    let data = []
    //月の初めの日までは何もなし
    for (let i = 0; i < startWeekday; i++) {
        data.push('')
    }
    //日付を追加します。
    for (let h = 1; h <= endDate; h++) {
        data.push(h)
    }
    return data
})
</script>

<template>
    <Head title="Dashboard" />

    <WorkerLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-7 gap-4">
                        <template v-for="date in dates">
                            <a href="">{{ date }}</a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </WorkerLayout>
</template>
