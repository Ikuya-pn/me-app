<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
    errors: Object,
})

const form = reactive({
    name: null,
    phone: null,
    postcode: null,
    address: null,
    memo: null,
})

const fetchAddress = () => {
  new YubinBangoCore(String(form.postcode), (value) => {
    console.log(value)
    form.address = value.region + value.locality + value.street
  })
}

const storeCustomer = () => {
    router.post('/admin/customer/store', form)
}

</script>

<template>

    <Head title="顧客登録" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客登録
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-10">
                    <section class="text-gray-600 body-font relative">
                        <form @submit.prevent="storeCustomer">
                            <div class="container px-5 py-8 mx-auto">
                            
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                                                <input type="text" id="name" name="name" v-model="form.name" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <InputError :message="errors.name"/>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="phone" class="leading-7 text-sm text-gray-600">電話番号</label>
                                                <input type="tel" id="phone" name="phone" v-model="form.phone" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <InputError :message="errors.phone"/>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号 (任意)</label>
                                                <input type="text" id="postcode" name="podtcode" v-model="form.postcode" @change="fetchAddress" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <InputError :message="errors.postcode"/>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                                <input type="text" id="address" name="address" v-model="form.address" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <InputError :message="errors.address"/>
                                            </div>
                                        </div>
            
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="memo" class="leading-7 text-sm text-gray-600">備考 (任意)</label>
                                                <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                <InputError :message="errors.memo"/>
                                            </div>
                                        </div>
                                        
                                        <div class="p-2 w-full mt-8">
                                            <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
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
