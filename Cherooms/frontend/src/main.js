import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import './assets/tailwind.css'
import FontAwesomeIcon from "@/plugin/fontawesome"
import { store } from './store'
// Vuesax Component Framework
// import Vuesax from 'vuesax'
// import 'material-icons/iconfont/material-icons.css' //Material Icons
// import 'vuesax/dist/vuesax.css' // Vuesax
// Vue.use(Vuesax)

import { plugin as vueMetaPlugin, createMetaManager, defaultConfig, resolveOption, useMeta } from 'vue-meta'

store.dispatch('setLogin')

const app = createApp(App)

app.use(router)
    .use(store)
    .use(createMetaManager(false, {
        body: {
            tag: "script",
            to: "body",
        },
        base: {
            valueAttribute: "href",
        },
        charset: {
            tag: "meta",
            nameless: true,
            valueAttribute: "charset",
        },
        description: {
            tag: "meta",
        },
        og: {
            group: true,
            namespacedAttribute: true,
            tag: "meta",
            keyAttribute: "property",
        },
        twitter: {
            group: true,
            namespacedAttribute: true,
            tag: "meta",
        },
        htmlAttrs: {
            attributesFor: "html",
        },
        headAttrs: {
            attributesFor: "head",
        },
        bodyAttrs: {
            attributesFor: "body",
        },
        robots: {
            tag: "meta",
        },
        keywords: {
            tag: "meta",
        },
        'Content-Security-Policy': {
            tag: "meta",
        }
        })) // add this line
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app')

