<template>
    <div class="grid">
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
                <div class="flex justify-content-between mb-3">
                    <div>
                        <span class="block text-500 font-medium mb-3">Wallet Balance</span>
                        <div class="text-900 font-medium text-xl">0.00</div>
                    </div>
                    <div class="flex align-items-center justify-content-center bg-blue-100 border-round" style="width: 2.5rem; height: 2.5rem">
                        <i class="pi pi-wallet text-blue-500 text-xl"></i>
                    </div>
                </div>
                <!-- <span class="text-green-500 font-medium">24 new </span>
                <span class="text-500">since last visit</span> -->
            </div>
        </div>
        
        
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
                <div class="flex justify-content-between mb-3">
                    <div>
                        <span class="block text-500 font-medium mb-3">Commission</span>
                        <div class="text-900 font-medium text-xl">0</div>
                    </div>
                    <div class="flex align-items-center justify-content-center bg-purple-100 border-round" style="width: 2.5rem; height: 2.5rem">
                        <i class="pi pi-users text-purple-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 xl:col-6">
            <div class="card">
                <h5>Recent Transactions</h5>
                <DataTable :value="transactions.recent" :rows="5" :paginator="true" responsiveLayout="scroll">
                    <Column style="width: 15%">
                        <template #header>ID</template>
                        <template #body="slotProps">
                            {{ slotProps.data.payment_id }}
                            <!-- <img :src="'demo/images/product/' + slotProps.data.image" :alt="slotProps.data.image" width="50" class="shadow-2" /> -->
                        </template>
                    </Column>
                    <Column field="name" header="Amount" :sortable="true" style="width: 35%">
                        <template #body="slotProps">
                            {{ formatCurrency(Number(slotProps.data.price_amount)) }}
                        </template>
                    </Column>
                    <Column field="price" header="Status" :sortable="true" style="width: 35%">
                        <template #body="slotProps">
                            <InlineMessage :severity="statusBadge(slotProps.data.payment_status)">{{ slotProps.data.payment_status }}</InlineMessage>
                        </template>
                    </Column>
                    <Column field="price" header="Date" :sortable="true" style="width: 35%">
                        <template #body="slotProps">
                            {{  formatTime(slotProps.data.created_at) }}
                        </template>
                    </Column>
                    <Column style="width: 15%">
                        <template #header> View </template>
                        <template #body>
                            <Button icon="pi pi-search" type="button" class="p-button-text"></Button>
                        </template>
                    </Column>
                </DataTable>
              
            </div>
        </div>

         <div class="col-12 xl:col-6">
            <div class="card md:mt-4 sm:mt-4 xs:mt-3">
                <div class="flex align-items-center justify-content-between mb-4">
                    <h5>Notifications</h5>
                    <div>
                        <!-- <Button icon="pi pi-ellipsis-v" class="p-button-text p-button-plain p-button-rounded" @click="$refs.menu1.toggle($event)"></Button> -->
                        <!-- <Menu ref="menu1" :popup="true" :model="items"></Menu> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 xl:col-6">
            <div class="card md:mt-4 sm:mt-4 xs:mt-3">
                <div class="flex align-items-center justify-content-between mb-4">
                    <h5>Notifications</h5>
                    <div>
                        <!-- <Button icon="pi pi-ellipsis-v" class="p-button-text p-button-plain p-button-rounded" @click="$refs.menu1.toggle($event)"></Button> -->
                        <!-- <Menu ref="menu1" :popup="true" :model="items"></Menu> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script lang="ts">
import { defineComponent, ref, watch, computed, reactive, onMounted, nextTick } from 'vue'
import { appLayout, accountService } from '../../lib';
import type { Balances } from '../../types/Account'
import type { Transaction } from '../../types/payments'

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InlineMessage from 'primevue/inlinemessage';
import Card from 'primevue/card';
import Button from 'primevue/button';
import { notify, formatCurrency } from '../../lib'

export default defineComponent({
    name: 'Dashboard',
    setup() {
        const { isDarkTheme } = appLayout();
        const products = ref(null);
        const lineOptions = ref<any>(null);
        const service = accountService()

        const balances = ref<Balances>({
            trading_balance: 0.00,
            active_trades: {
                count: 0,
                net_gain: 0.00
            },
            commission: 0,
            wallet: 0
        })
        const transactions = reactive({
            recent: ([])
        })

        const formatTime = (value: string) => {
            let date = new Date(value)
            return date.toLocaleString('en-US', {hour12: false})
        };

        onMounted(() => {
            nextTick(() => {
                loadBalances()
                loadRecent()
            })
        });
        // const trading_balance = ref<any>(0.00)
        const loadBalances = () => {
            service.balances().then((data: Balances) => {
                balances.value.trading_balance = data.trading_balance
                balances.value.active_trades = data.active_trades
                balances.value.commission = data.commission
                balances.value.wallet = data.wallet
                return loadRecent()
            }).catch((error) => {
                console.log(error)
                notify({
                    title: 'Error',
                    text: 'Unable to load balances, please refresh',
                    type: 'info'
                })
            })
        }

        const loadRecent = () => {
            service.recentTransactions().then((data) => {
                transactions.recent = data!
            }).catch((error) => {
                notify({
                    title: 'Error',
                    text: 'Unable to recent transactions, please refresh',
                    type: 'info'
                })
            })
        }
        
        const applyDarkTheme = () => {
            lineOptions.value = {
                plugins: {
                    legend: {
                        labels: {
                            color: '#ebedef'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ebedef'
                        },
                        grid: {
                            color: 'rgba(160, 167, 181, .3)'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ebedef'
                        },
                        grid: {
                            color: 'rgba(160, 167, 181, .3)'
                        }
                    }
                }
            };
        };
        const statusBadge = (status: string): string  => {
            switch(status) {
                case 'finished':
                    return 'success'
                case 'waiting':
                    return 'warn'
                case 'sending':
                case 'confirming':
                case 'confirmed':
                    return 'info'
                case 'refunded':
                    return 'contrast'
                case 'partially_paid':
                    return 'secondary'
                case 'failed':
                    return 'danger'
                default:
                    return 'danger'
            }
        }

        watch(isDarkTheme, (val) => {
                if (val) {
                    applyDarkTheme();
                } else {
                    // applyLightTheme();
                }
            },
            { immediate: true }
        );

        return { balances, formatCurrency, transactions, statusBadge, formatTime }
        
    } ,
    components: {
        DataTable,
        Column,
        Card,
        Button
    }
})
</script>