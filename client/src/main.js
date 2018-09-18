// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueRouter from 'vue-router'
import Auth from '@okta/okta-vue'

import Dashboard from './components/Dashboard.vue'
import MoviesList from './components/MoviesList.vue';

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(Auth, {
    issuer: 'https://dev-846151.oktapreview.com /oauth2/default',
    client_id: '{YOUR_CLIENT_ID}',
    redirect_uri: 'http://localhost:8080/implicit/callback',
    scope: 'openid profile email'
})

const routes = [
    { path: '/implicit/callback', component: Auth.handleCallback() },
    { path: '/', component: MoviesList },
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
