require('./bootstrap.js');
import Vue from 'vue';

import App from './components/App.vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueResource from 'vue-resource';
Vue.use(VueResource);

// import 'bootstrap-sass';
require('bootstrap-sass');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
Vue.use(ElementUI);

// import VueSummernote from 'vue-summernote';
// require('summernote/dist/summernote.css');
// Vue.use(VueSummernote, {
//     dialogsFade: true
// });

import store from './store';


// import '../../plugins/ueditor/ueditor.config.js';
// import '../../plugins/ueditor/ueditor.all.js';
// import '../../plugins/ueditor/lang/zh-cn/zh-cn.js';

// Vue.directive('ueditor', {
// 	params: ['config'],
// 	twoWay: true,
// 	bind: function (el) {
//         self = this;
// 		el.id = 'ueditor' + new Date().getTime().toString();
// 		var editor = UE.getEditor(el.id);
//         editor.ready(function () {
//             self.editorReady = true
//             self.editor.addListener("contentChange", function () {
//                 self.set(self.editor.getContent())
//             })
//             self.update(self.vm.$get(self.expression))
//         })
// 	}
// });

const routes = [
    { 
        path: '/login', 
        component: require('./components/user/Login.vue')
    },
    {
        path: '/password/reset',
        component: require('./components/user/PasswordReset.vue')
    },
    {
        path: '/', 
        component: require('./components/Main.vue'),
        children: [
            { 
                path: '/banner', 
                component: require('./components/banner/Banner.vue')
            },
            { 
                path: '/categories', 
                component: require('./components/category/Main.vue')
            },
            { 
                path: '/clients', 
                component: require('./components/client/Client.vue')
            },
            { 
                path: '/merchants', 
                component: require('./components/merchant/Merchant.vue')
            },
            { 
                path: '/products', 
                component: require('./components/product/Main.vue')
            },
            {
                path: '/orders',
                component: require('./components/order/Main.vue')
            },
            {
                path: '/lotteries',
                component: require('./components/lottery/record/Main.vue')
            },
            {
                path: '/win',
                component: require('./components/lottery/win/Main.vue')
            },
        ]
    },
];

const router = new VueRouter({
    routes
});

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next(function (response) {
        if (response.body.success == 0 && response.body.msg == '401') {
            router.replace('/login');
        }
    });
});
// router.beforeEach((to, from, next) => {
//     if (to.path != '/login') {
//         next('/login');
//     }
//     next();
// });

const app = new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App },
});
