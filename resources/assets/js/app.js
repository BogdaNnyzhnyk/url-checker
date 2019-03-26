import Vue from 'vue'

// view
import AppParserView from './views/AppParserView'

Vue.config.productionTip = false;

new Vue({
    components: {
        AppParserView
    },
}).$mount('#app');
