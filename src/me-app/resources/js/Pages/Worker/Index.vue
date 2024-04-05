<script setup>
import WorkerLayout from '@/Layouts/WorkerLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue'
import { ref, computed, onMounted } from 'vue'
import dayjs from 'dayjs'

const props = defineProps({
    works: Array,
    salary: String,
})

// 今月のカレンダー情報を計算
const calendarCells = computed(() => {
  const today = new Date();
  const currentYear = today.getFullYear();
  const currentMonth = today.getMonth();
  const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
  const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
  
  const cells = [];
  for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
    const isWorking = props.works.some(work => {
      const workDate = new Date(work.date);
      return workDate.getFullYear() === currentYear && workDate.getMonth() === currentMonth && workDate.getDate() === i;
    });
    cells.push({ date: i, isWorking });
  }
  // 曜日のずれを調整
  const firstDayOfWeek = firstDayOfMonth.getDay();
  for (let i = 0; i < firstDayOfWeek; i++) {
    cells.unshift({ date: '', isWorking: false });
  }

  return cells;
});

</script>

<template>
    <Head title="今月のシフト" />

    <WorkerLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="mb-8">
                        <FlashMessage />
                    </div>
                    <div> 
                        <div class="w-full text-center pt-8 mb-10">
                            <p class="text-3xl">{{ dayjs().format('M') }}月</p>
                        </div>
                        
                        <div class="grid grid-cols-7 gap-4 text-center pb-4">
                            <!-- 曜日ヘッダー -->
                            <p class="text-sm text-red-500">日</p>
                            <p class="text-sm">月</p>
                            <p class="text-sm">火</p>
                            <p class="text-sm">水</p>
                            <p class="text-sm">木</p>
                            <p class="text-sm">金</p>
                            <p class="text-sm text-blue-500 mb-6">土</p>
                            <!-- 日付表示 -->
                            <template v-for="cell in calendarCells" :key="cell.date">
                                <Link :href="route('worker.works.create', {date: cell.date})" class="h-16 border-b text-lg">
                                    <p>{{ cell.date }}</p>
                                    <template v-if="cell.isWorking">
                                        <span class="point text-4xl text-orange-500">・</span>
                                    </template>
                                </Link>
                            </template>
                        </div>
                    </div>
                    <div class="border border-gray-300 mt-14 w-4/5 mx-auto"></div>
                    <div class="w-4/5 mx-auto mt-12 pb-10">
                        <h1 class="text-right text-2xl">見込給料: ¥{{ salary }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </WorkerLayout>
</template>
