<template>
    <div class="surface-0 flex justify-content-center p-0">
        <div class="landing-wrapper p-0 overflow-hidden w-full">
            <home-navbar></home-navbar>
            <router-view />
            <home-footer></home-footer>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { HomeNavbar } from '../components'
import { HomeFooter } from '../components'
export default defineComponent({
    setup() {
        
        const title = import.meta.env.VITE_APP_NAME

        return {title }
    },
    components: {
        HomeNavbar,
        HomeFooter
    }
})

</script>

