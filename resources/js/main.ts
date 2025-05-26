import { createApp } from 'vue'
import { createPinia } from 'pinia';
import router from './router'
import App from './App.vue'

import { globalLoader } from 'vue-global-loader'
import Notifications from '@kyvg/vue3-notification'
import PrimeVue from "primevue/config";
import StyleClass from 'primevue/styleclass';
import BadgeDirective from 'primevue/badgedirective';
import Ripple from 'primevue/ripple';
import Tooltip from 'primevue/tooltip';

import './assets/styles.scss';
import "@fortawesome/fontawesome-free/css/all.min.css";

const app = createApp(App)
const pinia = createPinia()
app.use(pinia)
app.use(router)
app.use(PrimeVue, {ripple: true, unstyled: false })
app.use(Notifications)
app.use(globalLoader, {
    backgroundOpacity: 0.5,
    transitionDuration: 0.2
})
app.directive('tooltip', Tooltip);
app.directive('badge', BadgeDirective);
app.directive('ripple', Ripple);
app.directive('styleclass', StyleClass);
app.directive('prevent-unwanted-link', {
    // When the bound element is mounted into the DOM...
    mounted(el) {
        // Listen for click event
        el.addEventListener('click', (event: any) => {
          event.preventDefault()
          return
        })
    }
})
app.mount('#app')