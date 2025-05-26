<template>
    <div class="layout-wrapper" :class="containerClass">
        <app-navbar></app-navbar>
        <div class="layout-sidebar">
            <app-sidebar></app-sidebar>
        </div>
        <div class="layout-main-container">
            <div class="layout-main">
                <router-view></router-view>
            </div>
            <app-footer></app-footer>
        </div>
        <!-- <app-config></app-config> -->
        <div class="layout-mask"></div>
    </div>
    <!-- <Toast /> -->
</template>

<script lang="ts">
import { defineComponent, computed, watch, ref , onMounted } from 'vue';
import { appLayout } from '../lib'
import { AppNavbar, AppSidebar, AppFooter } from '../components'

export default defineComponent({

    setup() {
        
        const { layoutConfig, layoutState, isSidebarActive } = appLayout();
        const containerClass = computed(() => {
            return {
                'layout-theme-light': layoutConfig.darkTheme.value ?? 'light',
                'layout-theme-dark': layoutConfig.darkTheme.value ?? 'dark',
                'layout-overlay': layoutConfig.menuMode.value ?? 'overlay',
                'layout-static': layoutConfig.menuMode.value ?? 'overlay',
                'layout-static-inactive': layoutState.staticMenuDesktopInactive.value && layoutConfig.menuMode.value === 'overlay',
                'layout-overlay-active': layoutState.overlayMenuActive.value,
                'layout-mobile-active': layoutState.staticMenuMobileActive.value,
                'p-ripple-disabled': layoutConfig.ripple.value
            };
        });
        const outsideClickListener = ref<((event: any) => void) | null>(null);

        const bindOutsideClickListener = () => {
            if (!outsideClickListener.value) {
                outsideClickListener.value = (event) => {
                    if (isOutsideClicked(event)) {
                        layoutState.overlayMenuActive.value = false;
                        layoutState.staticMenuMobileActive.value = false;
                        layoutState.menuHoverActive.value = false;
                    }
                };
                document.addEventListener('click', outsideClickListener.value);
            }
        };
        const unbindOutsideClickListener = () => {
            if (outsideClickListener.value) {
                document.removeEventListener('click', outsideClickListener.value);
                outsideClickListener.value = null;
            }
        };
        const isOutsideClicked = (event: any) => {
            const sidebarEl = document.querySelector('.layout-sidebar');
            const topbarEl = document.querySelector('.layout-menu-button');

            return !(sidebarEl?.isSameNode(event.target) || sidebarEl?.contains(event.target) || topbarEl?.isSameNode(event.target) || topbarEl?.contains(event.target));
        };
        
        watch(isSidebarActive, (newVal) => {
            if (newVal) {
                bindOutsideClickListener();
            } else {
                unbindOutsideClickListener();
            }
        });
        return { containerClass }
    },
    components: {
        AppNavbar,
        AppSidebar,
        AppFooter
    }
})
</script>