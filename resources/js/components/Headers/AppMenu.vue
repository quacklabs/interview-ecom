<template>
    <ul class="layout-menu mt-5">
        <template v-for="(item, i) in items" :key="item">
            <menu-item v-if="!item.separator" :item="item" :index="i"></menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
    
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { type MenuGroup } from '../../types/UI';
import { default as MenuItem } from './AppMenuItem.vue'

export default defineComponent({
    setup() {
        const homeMenu: MenuGroup = {
            label: 'Overview',
            items: [
                { label: 'Dashboard', icon: 'pi pi-fw pi-home', to: {name: 'Account'} },
            ]
        }
        const productMenu: MenuGroup = {
            label: 'Product Management',
            items: [
                { label: 'View Products', icon: 'pi pi-fw pi-eye', to: {name: 'Account'} },
                { label: 'Add Products', icon: 'pi pi-fw pi-plus', to: {name: 'Account'} },
                { label: 'Products Categories', icon: 'pi pi-fw pi-box', to: {name: 'Account'} },
            ]
        }
        const cmsMenu: MenuGroup = {
            label: 'Content Management',
            items: [
                { label: 'Pages', icon: 'pi pi-fw pi-file', to: {name: 'Account'} },
            ]
        }
        const items = ref([
            homeMenu,
            productMenu,
            cmsMenu
        ])
        return { items }
    },
    components: {
        MenuItem
    }
})
</script>

<style lang="scss" scoped></style>
