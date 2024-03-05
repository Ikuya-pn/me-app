<script>
</script>

<template>
    <div v-if="$page.props.flash.status === 'success'" class="w-1/2 mx-auto mt-8 bg-blue-300 text-white px-3 py-2 rounded text-center">
        {{ $page.props.flash.message }}
    </div>
    <div v-if="$page.props.flash.status === 'danger'" class="w-1/2 mx-auto mt-8 bg-red-300 text-white px-3 py-2 rounded text-center">
        {{ $page.props.flash.message }}
    </div>
</template>