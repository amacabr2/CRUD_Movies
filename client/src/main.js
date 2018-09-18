// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard.vue'

Vue.config.productionTip = false

Vue.user(VueRouter)

const routes = [
    {path: '/', component: Dashboard}
]

const router = new VueRouter({
    mode: 'history',
    routes
})

/* eslint-disable no-new */
new Vue({
    router,
    render: h => h(Dashboard)
}).$mount('#app')
