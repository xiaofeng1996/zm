import Vue from 'vue';

const state = {
    datas: []
}

const actions = {
    getOrderGoods ({ state, commit, rootState }, order_id) {
        var _params = {
            order_id: order_id
        }
        Vue.http.get('/admin/order/goods', {params: _params}).then(response => {
            commit('setOrderGoods', response.body.infor);
        })
    }
}

const mutations = {
    setOrderGoods (state, datas) {
        state.datas = datas;
    }
}

export default {
    state,
    actions,
    mutations
}
