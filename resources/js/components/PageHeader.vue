<template>
  <div class="page-header">
    <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
      <h1 class="text-3xl font-medium text-900 mb-2 md:mb-0">{{ title }}</h1>
      <div class="flex align-items-center">
        <slot name="actions"></slot>
      </div>
    </div>
    <p v-if="description" class="mt-2 text-gray-600">{{ description }}</p>
    <Divider />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'PageHeader',
  props: {
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      default: ''
    }
  }
})
</script>

<style scoped>
.page-header {
  margin-bottom: 1.5rem;
}
</style>