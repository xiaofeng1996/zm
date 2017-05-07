import Vue from 'vue';

const state = {
    datas: [],
    total: 0,
    page_size: 20,
    searches: {
        out_trade_no: '',
        status: 0,
        name: '',
        mobile: '',
        is_lucky: -1
    },
    form_data: {
        id: 0,
        status: 2,
        express_name: '',
        express_nu: '',
    },
    is_dialog_visible: false,
    is_goods_visible: false
}

const actions = {
    getOrders ({ state, commit, rootState }, page) {
        var page = page ? page : 1;
        var data = state.searches;
        data.page = page;
        Vue.http.get('/admin/orders', {params: data}).then(response => {
            commit('setOrders', response.body.infor.data);
            commit('setOrdersTotal', response.body.infor.total);
            commit('setPageSize', response.body.infor.per_page);
        })
    }
}

const mutations = {
    setOrders (state, datas) {
        state.datas = datas;
    },
    setOrdersTotal (state, total) {
        state.total = total;
    },
    setOrderPageSize (state, page_size) {
        state.page_size = page_size;
    },
    openOrderDialog (state) {
        state.is_dialog_visible = true;
    },
    closeOrderDialog (state) {
        state.is_dialog_visible = false;
    },
    setOrderFormData (state, data) {
        state.form_data.id              = data.id;
        state.form_data.status          = data.status;
        state.form_data.express_name    = data.express_name;
        state.form_data.express_nu      = data.express_nu;
    },
    clearOrderFormData (state) {
        state.form_data.id              = 0;
        state.form_data.status          = '1';
        state.form_data.express_name    = '';
        state.form_data.express_nu      = '';
    },
    setOrderStatus (state, status) {
        state.form_data.status = status;
    },
    openOrderGoods (state) {
        state.is_goods_visible = true;
    },
    closeOrderGoods (state) {
        state.is_goods_visible = false;
    }
}

export default {
    state,
    actions,
    mutations
}
