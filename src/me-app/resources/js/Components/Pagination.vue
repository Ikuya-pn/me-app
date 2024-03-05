<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({ links: Array })

const firstLink = props.links[0];
const lastLink = props.links[props.links.length - 1];
</script>

<template>
    <div class="flex justify-around">
        <div v-if="firstLink">
            <Link v-if="firstLink.url" :href="firstLink.url">
                <span class="bg-blue-400 hover:bg-blue-300 text-white p-1 rounded text-sm">< 前へ</span>
            </Link>
        </div>
        <div v-if="lastLink">
            <Link v-if="lastLink.url" :href="lastLink.url">
                <span class="bg-blue-400 hover:bg-blue-300 text-white p-1 rounded text-sm">次へ ></span>
            </Link>
        </div>
    </div>
</template>