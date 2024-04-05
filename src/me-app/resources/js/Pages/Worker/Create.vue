<script setup>
import WorkerLayout from '@/Layouts/WorkerLayout.vue'
import { Head } from '@inertiajs/vue3'
import { reactive, computed, } from 'vue'
import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import MicroModal from '@/Components/MicroModal.vue'
import worktime from '@/worktimes'
import dayjs from 'dayjs'
import ja from 'dayjs/locale/ja'

const props = defineProps({
    errors: Object,
    date: String,
    existWork: Object,
    existFixWork: Object,
    errors: Object,
})

console.log(props.existFixWork)

let resultTime = null 
resultTime = computed(() => {
    return worktime.calElapseTime(form.start_time, form.end_time, form.break_time);
});

const form = reactive({ //DBにシフトのデータがあったら、初期値として入れる
    id: props.existWork ? props.existWork.id : null,
    start_time: props.existWork ? props.existWork.start_time : null,
    end_time: props.existWork ? props.existWork.end_time : null,
    break_time: props.existWork ? props.existWork.break_time : 0,
    result_time: props.existWork ? props.existWork.result_time : null,
    customer_id: null,
    is_locked: props.existWork ? props.existWork.is_locked : false,
    date: props.date,
})

dayjs.locale(ja)
const day = dayjs()

const handleSubmit = () => {
  console.log('値が送信されました。')
};

const storeWork = () => {
    if (confirm('シフトを登録しますか？(登録後は管理者への修正申請ができます。)')) {
        form.result_time = worktime.calElapseTime(form.start_time, form.end_time, form.break_time);
        router.post('/worker/works/store', form)
    }
}

const fixWork = () => {
    if (confirm('この内容で申請しますか？')) {
        form.result_time = worktime.calElapseTime(form.start_time, form.end_time, form.break_time);
        router.put(`/worker/works/update/${form.id}`, form)
    }
}

const setCustomerId = id => {
    form.customer_id = id
}

</script>

<template>

    <Head title="シフト登録" />

    <WorkerLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="handleSubmit" class="w-2/3 md:w-1/3 mx-auto py-8">
                        
                        <h2 v-if="form.is_locked === false" class="font-semibold text-lg text-gray-800 leading-tight">{{ day.format('M') }}月{{ props.date }}日にシフト追加</h2>
                        <h2 v-if="form.is_locked === 1 && existFixWork === null" class="font-semibold text-sm text-red-400 leading-tight">{{ day.format('M') }}月{{ props.date }}日のシフトは以下の内容で確定しています。修正がある場合は修正内容を入力し、申請を行ってください。</h2>
                        <h2 v-if="existFixWork !== null && existFixWork.necessity === 1" class="font-semibold text-sm text-red-400 leading-tight">以下の内容で修正申請中です。</h2>

                        <div class="w-full mt-6">
                            <label for="start_time" class="text-gray-600 text-sm">出勤時間</label><br>
                            <input v-if="form.is_locked === false" v-model="form.start_time" type="time" class="w-full rounded">
                            <input v-if="form.is_locked === 1 && existFixWork === null"  v-model="form.start_time" type="time" class="w-full rounded">
                            <input readonly v-if="existFixWork !== null && existFixWork.necessity === 1"  v-model="existFixWork.start_time" type="time" class="w-full rounded">
                            <InputError :message="errors.start_time" />
                        </div>
                        <div class="w-full mt-4">
                            <label for="end_time" class="text-gray-600 text-sm">退勤時間</label><br>
                            <input v-if="form.is_locked === false" v-model="form.end_time" type="time" class="w-full rounded">
                            <input v-if="form.is_locked === 1 && existFixWork === null"  v-model="form.end_time" type="time" class="w-full rounded">
                            <input readonly v-if="existFixWork !== null && existFixWork.necessity === 1"  v-model="existFixWork.end_time" type="time" class="w-full rounded">
                            <InputError :message="errors.end_time" />
                        </div>
                        <div class="w-full mt-4">
                            <label for="break_time" class="text-gray-600 text-sm">休憩時間</label><br>
                            <div class="flex items-center">
                                <input v-if="form.is_locked === false" v-model="form.break_time" id="break_time" placeholder="0" type="text" class="w-full rounded w-20"><span v-if="form.is_locked === false" class="ml-2 text-gray-500 text-sm">分</span>
                                <input v-if="form.is_locked === 1 && existFixWork === null" v-model="form.break_time" id="break_time" placeholder="0" type="text" class="w-full rounded w-20"><span v-if="form.is_locked === 1 && existFixWork === null" class="ml-2 text-gray-500 text-sm">分</span>
                                <input readonly v-if="existFixWork !== null && existFixWork.necessity === 1" v-model="existFixWork.break_time" id="break_time" placeholder="0" type="text" class="w-full rounded w-20"><span v-if="existFixWork !== null && existFixWork.necessity === 1" class="ml-2 text-gray-500 text-sm">分</span>
                            </div>
                            <InputError :message="errors.break_time"/>
                        </div>
                        <div v-if="form.is_locked === false" class="w-full mt-4">
                            <span class="text-gray-600 text-sm">合計勤務時間</span><br>
                            <input id="result_time" readonly type="time" class="w-full rounded border py-2 px-3 border-gray-300 text-gray-600" :value="resultTime">
                        </div>

                        <div class="w-full mt-4">
    
                            <MicroModal v-if="form.is_locked === false" @update:customerId="setCustomerId" />
                            <MicroModal v-if="form.is_locked === 1 && existFixWork === null" @update:customerId="setCustomerId" />
                        </div>
                        <button v-if="form.is_locked === false" @click="storeWork" type="submit" class="mt-10 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                        <button v-if="form.is_locked === 1 && existFixWork === null" @click="fixWork" type="submit" class="mt-10 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">修正を申請する</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </WorkerLayout>
</template>
