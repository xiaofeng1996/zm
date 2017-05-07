import Vue from 'vue';

const state = {
    datas: [],
    total: 0,
    page_size: 15,
    searches: {
        page: 1,
        out_trade_no: '',
        expect: '',
        status: -1,
        operate_status: -1
    },
    form_data: {
        id: 0,
        operate_status: 0,
        express_name: '',
        express_nu: ''
    },
    is_dialog_visible: false,
}

const actions = {
    getLotteryWins ({ state, commit, rootState }) {
        Vue.http.get('/admin/lottery/wins', {params: state.searches}).then(response => {
            commit('setLotteryWin', response.body.infor.data);
            commit('setLotteryWinTotal', response.body.infor.total);
            commit('setLotteryWinPageSize', response.body.infor.per_page);
        })
    }
}

const mutations = {
    setLotteryWin (state, datas) {
        state.datas = datas;
    },
    setLotteryWinTotal (state, total) {
        state.total = total;
    },
    setLotteryWinPageSize (state, page_size) {
        state.page_size = page_size;
    },
    openLotteryWinDialog (state) {
        state.is_dialog_visible = true;
    },
    closeLotteryWinDialog (state) {
        state.is_dialog_visible = false;
    },
    setLotteryFormData (state, data) {
        state.form_data.id              = data.id;
        state.form_data.operate_status  = data.operate_status;
        state.form_data.express_name    = data.express_name;
        state.form_data.express_nu      = data.express_nu;
    },
    clearLotteryFormData (state) {
        state.form_data.id              = 0;
        state.form_data.operate_status  = 0;
        state.form_data.express_name    = '';
        state.form_data.express_nu      = '';
    },
    setLotteryWinPage (state, page) {
        state.searches.page = page;
    }
}

export default {
    state,
    actions,
    mutations
}
