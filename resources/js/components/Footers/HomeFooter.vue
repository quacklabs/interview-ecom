<template>
<div class="py-4 px-4 mx-0 mt-8 lg:mx-8">
                <div class="grid justify-content-between">
                    <div class="col-12 md:col-4" style="margin-top: -1.5rem">
                        <a class="flex flex-wrap align-items-center justify-content-center md:justify-content-start md:mb-0 mb-3 cursor-pointer">
                            <img :src="logo" alt="footer sections" width="50" height="50" class="mr-2" />
                            <h4 class="font-medium text-3xl text-900">{{ title }}</h4>
                            <p class="text-200">
                                Trading in Forex/CFD carry a high level of risk to your capital due to the volatility of the underlying market. These products may not be suitable for all investors. Therefore, you should ensure that you understand the risks and seek advice from an independent and suitably licensed financial advisor.
                            </p>
                        </a>
                    </div>

                    <div class="col-12 md:col-8 lg:col-7">
                        <div class="grid text-center md:text-left">
                            <div class="col-12 md:col-4">
                                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">Company</h4>
                                <router-link :to="{name: 'About'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    About Us
                                </router-link>
                                <router-link :to="{name: 'Forex'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Forex
                                </router-link>
                                <router-link :to="{name: 'Commodities'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Commodities
                                </router-link>

                                <router-link :to="{name: 'Terms'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Terms of Service
                                </router-link>

                                <router-link :to="{name: 'Contact'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Contact Us
                                </router-link>
                            </div>

                            <div class="col-12 md:col-4 mt-4 md:mt-0">
                                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">Resources</h4>
                                <router-link :to="{name: 'Register'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Get Started
                                </router-link>
                                <router-link :to="{name: 'Faq'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    FAQ
                                </router-link>
                                <router-link :to="{name: 'Beginner'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Beginners Course
                                </router-link>

                                <router-link :to="{name: 'Intermediate'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Intermediate Course
                                </router-link>

                                <router-link :to="{name: 'Advanced'}" class="line-height-3 block cursor-pointer mb-2 text-500">
                                    Advanced Course
                                </router-link>
                                
                            </div>

                            <div class="col-12 md:col-4 mt-4 md:mt-0">
                                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">Contact Us</h4>
                                <a class="line-height-3 block cursor-pointer mb-2 text-500"><i class="pi pi-envelope"></i> {{ email }}</a>
                                <a class="line-height-3 block cursor-pointer mb-2 text-500"><i class="pi pi-phone"></i> {{ phone }}</a>
                                <a class="line-height-3 block cursor-pointer text-500"><i class="pi pi-map-marker"></i> {{  address }}</a>
                                
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
    setup() {

        const title = import.meta.env.VITE_APP_NAME
        const email = import.meta.env.VITE_APP_EMAIL
        const phone = import.meta.env.VITE_APP_PHONE
        const address = import.meta.env.VITE_APP_ADDRESS
        const { logo } = useConfig()

        return {title, email, phone, logo, address }
    }
})
</script>