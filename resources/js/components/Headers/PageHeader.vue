<template>
    <div class="hero">
        <div class="relative p-8 overflow-hidden">
            <img :src="banner" alt="Image" class="absolute top-0 left-0 w-auto h-full block md:w-full">
            
            <div class="my-6 relative">
                    <ul class="list-none p-0 m-0 flex align-items-center font-medium mb-3">
                        <li>
                            <a class="text-500 no-underline line-height-3 cursor-pointer">Pages</a>
                        </li>
                        <li class="px-2">
                            <i class="pi pi-angle-right text-500 line-height-3">{{  page }}</i>
                        </li>
                        <li>
                            <span class="text-900 line-height-3"></span>
                        </li>
                    </ul>
                    <div class="flex align-items-start flex-column lg:justify-content-between lg:flex-row">
                        <div>
                            <div class="font-medium text-3xl text-900">{{ title }}</div>
                            
                        </div>
                        <div class="mt-3 lg:mt-0">
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>
    
    
<script lang="ts">
import { defineComponent } from 'vue'; 
import { useConfig } from '../../lib';   
    
export default defineComponent({
    props: {
        page: {
            default: '',
            require: true
        },
        title: {
            default: '',
            require: true
        }
    },
    setup() {
        const banner = import.meta.env.VITE_APP_URL + 'img/banner.png'
        return { banner }
    }
})
</script>
    

<style scoped>
.hero {
    overflow: hidden;
}
</style>