import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

import state from './state'
import mutations from './mutations'
import actions from './actions'

import banner from './modules/banner'
import merchant from './modules/merchant'
import product from './modules/product'
import product_goods from './modules/product_goods'
import product_images from './modules/product_images'
import category from './modules/category'
import order from './modules/order'
import lottery from './modules/lottery'
import order_goods from './modules/order_goods'

export default new Vuex.Store({
  state,
  actions,
  mutations,
  modules: {
    banner,
    merchant,
    product,
    product_goods,
    product_images,
    category,
    order,
    lottery,
    order_goods
  },
})