<template>
    
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from 'vue';

export default defineComponent({
    setup() {
        const appName = import.meta.env.VITE_APP_NAME
        
        onMounted(() => {
           
        })
        return { appName }
    },
    components: {
    }
})
</script>