import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createI18n } from 'vue-i18n';
import { getFileIcon, getFileIconComponent } from './utils/fileIcons';


// وارد کردن فایل‌های زبان
import en from './lang/en';
import fa from './lang/fa';
import ar from './lang/ar';

// مقداردهی i18n
const i18n = createI18n({
    locale: localStorage.getItem('locale') || 'fa',
    fallbackLocale: 'en',
    messages: { en, fa, ar }
});

const appName = import.meta.env.VITE_APP_NAME || 'dictionary';

window.getFileIcon = getFileIcon;
window.getFileIconComponent = getFileIconComponent;

createInertiaApp({
    title: (title) => `${title} - Modern Dictionary`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(i18n);
        app.use(ZiggyVue);

        app.mount(el);
    },
    progress: {
        color: '#4B5563', // رنگ پیشرفت بارگذاری
    },
}).catch(err => console.error("Inertia app setup error:", err));
