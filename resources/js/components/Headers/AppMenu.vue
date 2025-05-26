<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in items" :key="item">
            <menu-item v-if="!item.separator" :item="item" :index="i"></menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
    
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { type MenuGroup } from '../../types/UI';
// @ts-ignore
import { default as MenuItem } from './AppMenuItem.vue'

export default defineComponent({
    setup() {
        const items = [{}]
        return { items }
    },
    components: {
        MenuItem
    }
})
</script>

<style lang="scss" scoped></style>
