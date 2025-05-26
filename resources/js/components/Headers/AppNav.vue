<template>
    <div class="layout-topbar">
        <router-link :to="{name: 'Account'}" class="layout-topbar-logo">
            <img alt="logo" :src="logo" />
            <span>{{  title  }}</span>
        </router-link>

        <button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle()">
            <i class="pi pi-bars"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>

        <div class="layout-topbar-menu" :class="topbarMenuClasses">
            <!-- <button  class="p-link layout-topbar-button">
                <i class="pi pi-wallet"></i>
                <span>{{ wallet_balance }}</span>
            </button> -->
            <button @click="onSettingsClick()" class="p-link layout-topbar-button">
                <i class="pi pi-cog"></i>
                <span>Settings</span>
            </button>

            <router-link :to="{name: 'logout'}" tag="span">
                <button class="p-link layout-topbar-button">
                    <i class="pi pi-power-off"></i>
                    <span>Logout</span>
                </button>
            </router-link>

            
        </div>
    </div>

</template>

<script lang="ts">
import { defineComponent, ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import { appLayout } from '../../lib';
import { useRouter } from 'vue-router';
import { useConfig } from '../../lib';

export default defineComponent({
    
    setup() {
        const { layoutConfig, layoutState, isSidebarActive, onMenuToggle } = appLayout();
        
        const router = useRouter();
        const outsideClickListener = ref<any>(null);
        const topbarMenuActive = ref<boolean>(false);
        const wallet_balance = ref<string>("Connect Wallet")
        const { logo } = useConfig()

        const topbarMenuClasses = computed(() => {
            return {
                'layout-topbar-menu-mobile-active': topbarMenuActive.value
            };
        });
        const title: string = import.meta.env.VITE_APP_NAME

        onMounted(() => {
            bindOutsideClickListener();
        });


        onBeforeUnmount(() => {
            unbindOutsideClickListener();
        });

        const onTopBarMenuButton = () => {
            topbarMenuActive.value = !topbarMenuActive.value;
        };

        const onSettingsClick = () => {
            topbarMenuActive.value = false;
            router.push({name: 'AccountSettings'});
        };
        // // return { topbarMenuClasses, title, onTopBarMenuButton }

        const isOutsideClicked = (event: { target: Node | null; }) => {
            const sidebarEl = document.querySelector('.layout-sidebar');
            const topbarEl = document.querySelector('.layout-menu-button');

            return !(sidebarEl?.isSameNode(event.target) || sidebarEl?.contains(event.target) || topbarEl?.isSameNode(event.target) || topbarEl?.contains(event.target));
        };

        const bindOutsideClickListener = () => {
            if (!outsideClickListener.value) {
                outsideClickListener.value = (event: any) => {
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

        watch(isSidebarActive, (newVal) => {
            if (newVal) {
                bindOutsideClickListener();
            } else {
                unbindOutsideClickListener();
            }
        });

        return { title, topbarMenuClasses, onSettingsClick, onMenuToggle, onTopBarMenuButton, wallet_balance, logo }
    }
})
</script>