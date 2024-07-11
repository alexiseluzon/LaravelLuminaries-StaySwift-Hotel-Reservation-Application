import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { Ziggy } from './ziggy';
import '@fortawesome/fontawesome-free/css/all.css';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {faClipboardList, faPlusCircle, faCheckCircle, faTags, faBalanceScale, faGraduationCap, faCog, faEdit,
   faTrashAlt, faDoorOpen, faSort, faSortUp, faSortDown, faPieChart, faCaretLeft, faCaretRight, faHandshake, faTools, 
   faShoppingCart, faUserGraduate, faUserTie, faUser, faCalendarPlus, faCalendarCheck, faInfoCircle, faReply,
   faThumbsUp, faWarning} from '@fortawesome/free-solid-svg-icons';

// Add the icons to the library
library.add(faClipboardList, faPlusCircle, faCheckCircle, faTags, faBalanceScale, faGraduationCap, faCog, faEdit,
   faTrashAlt, faDoorOpen, faSort, faSortUp, faSortDown, faPieChart, faCaretLeft, faCaretRight, faHandshake,
   faTools, faShoppingCart, faUserGraduate, faUserTie, faUser, faCalendarPlus, faCalendarCheck, faInfoCircle, faReply, 
   faThumbsUp, faWarning);

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy);
      
    // Register FontAwesome component globally
    app.component('font-awesome-icon', FontAwesomeIcon);

    app.mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
