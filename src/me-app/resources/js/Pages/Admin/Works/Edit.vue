<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import { reactive, computed, } from 'vue'
import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import MicroModal from '@/Components/MicroModal.vue'
import worktime from '@/worktimes'

const props = defineProps({
    errors: Object,
    existWork: Object
})

console.log(props.existWork)

let resultTime = null 
resultTime = computed(() => {
    return worktime.calElapseTime(form.start_time, form.end_time, form.break_time);
});

const form = reactive({ //DBにシフトのデータがあったら、初期値として入れる
    id: props.existWork.id,
    start_time: props.existWork.start_time,
    end_time: props.existWork.end_time,
    break_time: props.existWork.break_time,
    result_time: props.existWork.result_time,
    customer_id: null,
    is_locked: true,
    date: props.existWork.date,
    worker_id: props.existWork.worker_id
})

const handleSubmit = () => {
  console.log('値が送信されました。')
};

const fixWork = () => {
    if (confirm('この内容で登録しますか？')) {
        form.result_time = worktime.calElapseTime(form.start_time, form.end_time, form.break_time);
        router.put(`/admin/works/update/${form.id}`, form)
    }
}

const setCustomerId = id => {
    form.customer_id = id
}

const deleteWork = id => {
    if(confirm('このシフトを完全に削除しますか？')){
        router.delete(`/admin/works/delete/${id}`)
    }
}

</script>

<template>

    <Head title="シフト更新" />

    <WorkerLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="handleSubmit" class="w-2/3 md:w-1/3 mx-auto py-8">
                        
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                            <span class="font-semibold text-lg text-gray-800 leading-tight">{{ props.existWork.worker.name }} さん </span><br>
                            {{ props.existWork.date }}のシフトを変更
                        </h2>

                        <div class="w-full mt-6">
                            <label for="start_time" class="text-gray-600 text-sm">出勤時間</label><br>
                            <input v-model="form.start_time" type="time" class="w-full rounded">
                            <InputError :message="errors.start_time" />
                        </div>
                        <div class="w-full mt-4">
                            <label for="end_time" class="text-gray-600 text-sm">退勤時間</label><br>
                            <input v-model="form.end_time" type="time" class="w-full rounded">
                            <InputError :message="errors.start_time" />
                        </div>
                        <div class="w-full mt-4">
                            <label for="break_time" class="text-gray-600 text-sm">休憩時間</label><br>
                            <div class="flex items-center">
                                <input v-model="form.break_time" id="break_time" placeholder="0" type="text" class="w-full rounded w-20"><span v-if="form.is_locked === false" class="ml-2 text-gray-500 text-sm">分</span>
                            </div>
                            <InputError :message="errors.break_time"/>
                        </div>
                        <div class="w-full mt-4">
                            <span class="text-gray-600 text-sm">合計勤務時間</span><br>
                            <input id="result_time" readonly type="time" class="w-full rounded border py-2 px-3 border-gray-300 text-gray-600" :value="resultTime">
                        </div>

                        <div class="w-full mt-4">
                            <MicroModal @update:customerId="setCustomerId" />
                        </div>
                        <div class="mt-10 mx-auto flex justify-between items-end">
                            <button @click="fixWork" type="submit" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                            <button @click="deleteWork(existWork.id)" class="text-gray-600 hover:text-gray-700 underline whitespace-nowrap ml-4">削除する</button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </WorkerLayout>
</template>
