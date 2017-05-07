
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */



// 改为直接在 webpack 配置文件中加入全局
// window.$ = window.jQuery = require('jquery');
// require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

// window.Vue = require('vue');
// require('vue-resource');

// window.VueSummernote = require('vue-summernote');

// window.ElementUI = require('element-ui');
// require('element-ui/lib/theme-default/index.css');

// import Vueditor, {createEditor} from 'vueditor';
// import "vueditor/dist/css/vueditor.min.css";
// let config = {
//      // buttons on the toolbar, you can use '|' or 'divider' as the separator
//     toolbar: [
//       'removeFormat', 'undo', '|', 'elements', 'fontName', 'fontSize', 'foreColor', 'backColor', 'divider',
//       'bold', 'italic', 'underline', 'strikeThrough', 'links', 'divider', 'subscript', 'superscript',
//       'divider', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull', '|', 'indent', 'outdent',
//       'insertOrderedList', 'insertUnorderedList', '|', 'emoji', 'picture', 'tables', '|', 'switchView'
//     ],

//     // the font-family select's options, "val" refer to the actual css value, "abbr" refer to the option's text
//     // "abbr" is optional when equals to "val";
//     fontName: [
//       {val: "", abbr: ""},
//       {val: "arial black"}, {val: "times new roman"}, {val: "Courier New"}
//     ],

//     // the font-size select's options
//     fontSize: ['12px', '14px', '16px', '18px', '0.8rem', '1.0rem', '1.2rem', '1.5rem', '2.0rem'],

//     // the emoji list, you can get full list here: http://unicode.org/emoji/charts/full-emoji-list.html
//     emoji: ["1f600", "1f601", "1f602", "1f923", "1f603"],

//     // default is Chinese, to set to English use lang: 'en'
//     lang: 'en',

//     // mode options: default | iframe
//     mode: 'default',

//     // if mode is set to 'iframe', specify a HTML file path here
//     iframePath: '',

//      // your file upload url, the return result must be a string refer to the uploaded image, leave it empty will end up with local preview
//     fileuploadUrl: ''
// }



// window.Vuex = require('vuex');
// window.VueRouter = require('vue-router');
// require('./router.js');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

// Vue.http.interceptors.push((request, next) => {
//     request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
//     next();
// });


// // ueditor
// Vue.directive('ueditor', {
//     params: ['config'],
//     twoWay: true,
//     bind: function () {
//         var self = this;
//         this.el.id = 'ueditor' + new Date().getTime().toString()
//         this.editor = UE.getEditor(this.el.id, this.params.config)
//         this.editor.ready(function () {
//             self.editorReady = true
//             self.editor.addListener("contentChange", function () {
//                 self.set(self.editor.getContent())
//             })
//             self.update(self.vm.$get(self.expression))
//         })
//     },
//     update: function (newValue, oldValue) {
//         if (this.editorReady) {
//             this.editor.setContent(newValue)
//         }
//     },
//     unbind: function () {
//         this.editor.destroy()
//     }
// })

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
