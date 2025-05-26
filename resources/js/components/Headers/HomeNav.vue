
<template>
    <Menubar :model="items" class="w-full">
        <template #start>
            <img class="h-3rem" :src="logo" />
        </template>
        <template #item="{ item, props, hasSubmenu }">
            <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                <a v-ripple :href="href" v-bind="props.action" @click="navigate" class="">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                </a>
            </router-link>
            <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                <span :class="item.icon" />
                <span class="ml-2">{{ item.label }}</span>
                <span v-if="hasSubmenu" class="pi pi-fw pi-angle-right ml-2" />
            </a>
        </template>
            <template #end>
                <div class="flex align-items-center gap-2">
                    <router-link :to="{name: 'Login'}">
                        <Button severity="info" label="Login" icon="pi pi-key"></Button>
                    </router-link>

                    <router-link :to="{name: 'Register'}">
                        <Button severity="success" label="Register" icon="pi pi-user"></Button>
                    </router-link>
                </div>
            </template>
        </Menubar>
</template>

<script lang="ts">
import { ref, defineComponent } from "vue";
import Button from 'primevue/button'
import Menubar from 'primevue/menubar'
import { useConfig } from '../../lib';

export default defineComponent({
    setup() {

        const items = ref([
            {
                label: 'Home',
                route: {name: 'Home'}
            },
        ]);
        const { logo } = useConfig()
        const title = import.meta.env.VITE_APP_NAME

        return { items, logo, title }
    },
    components: {
        Menubar
    }
})
</script>