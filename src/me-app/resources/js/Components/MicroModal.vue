<script setup>
    import {ref, reactive, onMounted} from 'vue'
    import axios from 'axios'

    const isShow = ref(false)
    const toggleStatus = () => {
        isShow.value = !isShow.value
    }

    const search = ref('')

    const customers = reactive({})

    const searchCustomers = async () => {
        try{
            await axios.get(`/api/searchCustomers/?search=${search.value}`)
            .then(res => {
                console.log(res.data)
                customers.value = res.data
            })
            isShow.value = !isShow.value
        } catch (e){
            console.log(e.message)
        }
    }

    const emit = defineEmits(['update:customerId'])

    const setCustomer = e => {
        search.value = e.name
        emit('update:customerId', e.id)
        toggleStatus()
    }
</script>

<template>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                       お客様検索
                    </h2>
                    <button @click="toggleStatus" type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <table v-if="customers.value" class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">氏名</th>
                                <th class="px-3 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">住所</th>
                                <th class="px-3 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">備考</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers.value" :key="customer.id">
                                    <td class="px-3 py-3 border-b-2 border-gray-200 text-sm whitespace-nowrap">
                                        <button @click="setCustomer({ id: customer.id, name: customer.name })" type="button" class="hover:bg-gray-100">
                                            {{ customer.name }}
                                        </button>
                                    </td>
                                    <td class="px-3 py-3 border-b-2 border-gray-200 text-sm whitespace-nowrap">
                                        <button @click="setCustomer({ id: customer.id, name: customer.name })" type="button" class="hover:bg-gray-100">
                                            {{ customer.address }}
                                        </button>
                                    </td>
                                    <td class="px-3 py-3 border-b-2 border-gray-200 text-sm">
                                        <button @click="setCustomer({ id: customer.id, name: customer.name })" type="button" class="hover:bg-gray-100">
                                            {{ customer.memo }}
                                        </button> 
                                    </td>
                            </tr>
                        </tbody>
                    </table>
                </main>
                <footer class="modal__footer">
                    <button @click="toggleStatus" type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
                </footer>
            </div>
        </div>
    </div>
    <div>
        <label for="customer_id" class="text-gray-600 text-sm">勤務先のお客様</label><br>
        <div class="flex justify-between items-center">
            <input name="customer" v-model="search" class="rounded">
            <button @click="searchCustomers" type="button" class="bg-blue-400 hover:bg-blue-300 text-white text-sm ml-2 px-3 py-2 rounded whitespace-nowrap">検索する</button>
        </div>
        
    </div>
    
</template>