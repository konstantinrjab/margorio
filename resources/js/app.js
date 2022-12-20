import './bootstrap';
import {createApp} from 'vue';
import InvoiceGeneration from './components/InvoiceGeneration.vue';
import TurbolinksAdapter from 'vue-turbolinks';

document.addEventListener('turbo:load', () => {
    const element = document.getElementById('app');
    if (element != null) {
        const app = createApp({})
            .component('InvoiceGeneration', InvoiceGeneration)
            .use(TurbolinksAdapter)

        app.mount('#app')
    }
});
