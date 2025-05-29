<template>
	<div class="card">
        <div class="font-semibold text-xl mb-4">Categories</div>
        <DataTable
            :value="categories.all"
            :paginator="true"
            :rows="10"
            dataKey="name"
            :rowHover="true"
            v-model:filters="filters"
            filterDisplay="menu"
            :loading="isLoading"
            :filters="filters"
            :globalFilterFields="['name']"
            showGridlines
        >
            <template #header>
                <div class="flex justify-between">
                    <Button class="mr-5" type="button" icon="pi pi-plus" label="Add New" outlined @click="showForm"/>
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                    </IconField>
                </div>
            </template>
            <template #empty> No categories found. </template>
            <template #loading> Loading categories data. Please wait... </template>
            <Column field="name" header="Name" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.name }}
                </template>
                <template #filter="{ filterModel }">
                    <InputText v-model="filterModel.value" type="text" placeholder="Search by name" />
                </template>
            </Column>
            
            <Column field="verified" header="Actions" dataType="boolean" bodyClass="text-center" style="min-width: 8rem">
                <template #body="{ data }">
                    <Button type="danger" @click="deleteCategory(data.id)">Delete</Button>
                    
                </template>
            </Column>
        </DataTable>
    </div>

    <Dialog header="Add Category" v-model:visible="displayForm" :breakpoints="{ '960px': '75vw' }" :style="{ width: '30vw' }" :modal="true">
        <div class="md:w-1/1">
            <div class="card">
                <div class="grid grid-cols-12 gap-2">
                    <label for="name3" class="flex items-center col-span-12 mb-2 md:col-span-2 md:mb-0">Name</label>
                    <div class="col-span-12 md:col-span-10">
                        <InputText class="w-full" id="name3" type="text" v-model.trim="form.name"/>
                        <InlineMessage class="w-full" severity="warn" v-if="v$.name.$error"> {{ v$.name.$errors[0].$message }} </InlineMessage>
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <Button label="Save" @click="save" />
        </template>
    </Dialog>
</template>

<script lang="ts">
import { defineComponent, ref, reactive, onBeforeMount, computed } from 'vue';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import { useGlobalLoader } from 'vue-global-loader'
import { useNetwork, notify } from '../../lib'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'

export default defineComponent({
    name: 'YourComponentName',
    setup() {
        const filters = ref(null);

        const req = useNetwork()
        const displayForm = ref(false)
        
        const categories = reactive({
            all: ([])
        });

        const form = reactive({
            name: ""
        })
        const rules = computed(() => {
            return {
              name: { required }  
            }
        })

        const v$ = useVuelidate(rules, form)

        const { isLoading, displayLoader, destroyLoader } = useGlobalLoader()

        
        function initFilters(): void {
            filters.value = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name: {
                    operator: FilterOperator.AND,
                    constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }]
                }
            };
        }

        function formatCurrency(value: number): string {
            return value.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });
        }

        function formatDate(value: Date | string): string {
            return new Date(value).toLocaleDateString('en-US', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        const  showForm = () => {
        	displayForm.value = !displayForm.value
        }

        const save = async () => {
            if (!(await v$.value.$validate())) return;

            displayLoader()
            req.push('add_category', {name: form.name}).then((resp) => {
                categories.push(resp.data)
            }).catch((error) => {
                notify({
                    type: 'error',
                    title: 'Error',
                    text: error.message
                })

            }).finally(() => destroyLoader())

        }

        const deleteCategory = (id: number) => {
            displayLoader()
            req.push('delete_category', {id: id}).then((resp) => {
                loadCategories()
            }).catch((error) => {
                notify({
                    type: 'error',
                    title: 'Error',
                    text: error.message
                })
            }).finally(() => destroyLoader())
        }

        const loadCategories = () => {
            displayLoader()
            req.fetch('get_categories').then((resp) => {
                const data: PaginatedResponse = resp.data;
                
                categories.all = data.data;
                // pagination.totalRecords = data.meta.total;
                // pagination.page = data.meta.current_page;
            }).finally(() => destroyLoader())
        }

        onBeforeMount(() => {
            loadCategories()
            initFilters();
        });

        return {
            filters,
            isLoading,
            showForm, displayForm, form, v$, save, categories, deleteCategory
        };
    }
});
</script>
