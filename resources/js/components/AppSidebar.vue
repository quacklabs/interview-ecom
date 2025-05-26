<template>
    <app-menu></app-menu>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

import { default as AppMenu } from './Headers/AppMenu.vue'

export default defineComponent({
    components: {
        AppMenu
    },
    setup() {

        return { }
    },
})
</script>