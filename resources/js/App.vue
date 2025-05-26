<template>
    <GlobalLoader>
      <CircleSpinner />
    </GlobalLoader>
    <notifications position="top right"/>
    <router-view />
</template>

<script lang="ts">
import { defineComponent, onMounted } from 'vue'
import GlobalLoader from 'vue-global-loader/GlobalLoader.vue'
import CircleSpinner from 'vue-global-loader/CircleSpinner.vue'

import { Notifications } from '@kyvg/vue3-notification';

export default defineComponent({
  setup() {
    return {}
  },
  components: {
    GlobalLoader,
    CircleSpinner,
    Notifications
  },
})
</script>
