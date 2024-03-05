<script setup>
    import dayjs from 'dayjs'
    const day = dayjs()
</script>

<template>
    <div>{{ day.format('dd') }}</div>
    <div>{{ day.format('M') }}</div>
</template>