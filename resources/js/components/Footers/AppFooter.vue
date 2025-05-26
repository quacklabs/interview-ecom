<template>
    <div class="layout-footer">
        <img :src="logo" alt="Logo" height="20" class="mr-2" />
        by
        <span class="font-medium ml-2">{{ title }}</span>
    </div>
</template>


<script lang="ts">
import { defineComponent } from 'vue'
import { useConfig } from '../../lib'

export default defineComponent({
    setup() {
        const { logo } = useConfig()
        const title = import.meta.env.VITE_APP_NAME
        return { logo, title }
    }
})
</script>