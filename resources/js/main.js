// import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'

import './setup/coreui'
import './setup/bootstrap-vue'
import './setup/3rd-libraries'
import './setup/user-defined'

import './assets/icons/fa-icons'

import store from './store'

Vue.config.performance = true
Vue.config.productionTip = false

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        App,
    },
    template: '<App/>',
})

store.$app = app
