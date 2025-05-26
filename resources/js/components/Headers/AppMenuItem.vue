<template>
    <li :class="{ 'layout-root-menuitem': root, 'active-menuitem': isActiveMenu }">
        <div v-if="root && item.visible !== false" class="layout-menuitem-root-text">{{ item.label }}</div>
        <a v-if="(!item.to || item.items) && item.visible !== false" :href="item.url" @click="itemClick($event, item, index)" :class="item.class" :target="item.target" tabindex="0">
            <i :class="item.icon" class="layout-menuitem-icon"></i>
            <span class="layout-menuitem-text">{{ item.label }}</span>
            <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items"></i>
        </a>
        <router-link v-if="item.to && !item.items && item.visible !== false" @click="itemClick($event, item, index)" :class="[item.class, { 'active-route': checkActiveRoute(item) }]" tabindex="0" :to="item.to">
            <i :class="item.icon" class="layout-menuitem-icon"></i>
            <span class="layout-menuitem-text">{{ item.label }}</span>
            <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items"></i>
        </router-link>
        <Transition v-if="item.items && item.visible !== false" name="layout-submenu">
            <ul v-show="root ? true : isActiveMenu" class="layout-submenu">
                <app-menu-item v-for="(child, i) in item.items" :key="child" :index="i" :item="child" :parentItemKey="itemKey" :root="false"></app-menu-item>
            </ul>
        </Transition>
    </li>

</template>

<script lang="ts">
import { defineComponent, ref, onBeforeMount, watch } from 'vue';
import { appLayout } from '../../lib';
import { useRoute } from 'vue-router';
// import {default as MenuItem } from './'

export default defineComponent({
    props: {
        item: {
            type: Object,
            default: () => ({})
        },
        index: {
            type: Number,
            default: 0
        },
        root: {
            type: Boolean,
            default: true
        },
        parentItemKey: {
            type: String,
            default: null
        }
    },
    setup(props) {
        const { layoutConfig, layoutState, setActiveMenuItem, onMenuToggle } = appLayout();
        const route = useRoute()
        const isActiveMenu = ref(false);
        const itemKey = ref<string | null>(null);

        onBeforeMount(() => {
            itemKey.value = props.parentItemKey ? props.parentItemKey + '-' + props.index : String(props.index);
            // const activeItem = layoutState.overlayMenuActive;

            // isActiveMenu.value = activeItem === itemKey.value || activeItem ? activeItem.startsWith(itemKey.value + '-') : false;
        });
        // @ts-ignore
        const itemClick = (event, item, index) => {
            if (item.disabled) {
                event.preventDefault();
                return;
            }

            const { overlayMenuActive, staticMenuMobileActive } = layoutState;

            if ((item.to || item.url) && (staticMenuMobileActive.value || overlayMenuActive.value)) {
                onMenuToggle();
            }

            if (item.command) {
                item.command({ originalEvent: event, item: item });
            }

            const foundItemKey = item.items ? (isActiveMenu.value ? props.parentItemKey : itemKey) : itemKey.value;

            setActiveMenuItem(foundItemKey);
        };

        // @ts-ignore
        const checkActiveRoute = (item) => {
            return route.path === item.to;
        };

        watch(
            () => layoutConfig.activeMenuItem.value,
            (newVal: string | null) => {
                if(newVal) {
                    isActiveMenu.value = (newVal === itemKey.value || newVal!.startsWith(itemKey.value + '-'));
                } else {
                    isActiveMenu.value = false
                }
                // isActiveMenu.value = newVal === itemKey.value || newVal?.startsWith(itemKey.value + '-');
            }
        );

        return { setActiveMenuItem, onMenuToggle, isActiveMenu, itemClick, itemKey, checkActiveRoute }
    }
})
</script>