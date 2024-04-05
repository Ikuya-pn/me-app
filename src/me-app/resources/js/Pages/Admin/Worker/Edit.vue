<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue'
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    worker: Object,
    errors: Object,
})

const form = reactive({
    id: props.worker.id,
    name: props.worker.name,
    email: props.worker.email,
    hourly_wage: props.worker.hourly_wage,
})

const updateWorker = () => {
    router.put(`/admin/worker/update/${form.id}`, form)
}

</script>

<template>

    <Head title="スタッフ編集" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                スタッフ編集
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-10">
                    <section class="text-gray-600 body-font relative">
                        <form @submit.prevent="updateWorker">
                            <div class="container px-5 py-8 mx-auto">
                            
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                                <input type="text" id="name" v-model="form.name" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <InputError :message="errors.name"/>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                                <input type="email" id="email" v-model="form.email" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <InputError :message="errors.email"/>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="hourly_wage" class="leading-7 text-sm text-gray-600">時給</label>
                                                <div class="flex items-center">
                                                    <input type="hourly_wage" id="hourly_wage" v-model="form.hourly_wage" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <span class="ml-2">円</span>
                                                </div>
                                                <InputError :message="errors.hourly_wage"/>
                                            </div>
                                        </div>
                                        
                                        <div class="p-2 w-full mt-8">
                                            <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
