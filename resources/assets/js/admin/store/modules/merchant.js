
import Vue from 'vue';

const state = {
    datas: [],
    total: 0,
    page_size: 20,
    form_data: {
        id: 0,
        name: '',
        image: '',
        mobile: '',
        province: '',
        city: '',
        district: '',
        address: '',
        fare: 0
    },
    is_dialog_visible: false
}

const actions = {
    getDatas ({ state, commit, rootState }, page) {
        page = page ? page : 1;
        var url = rootState.host + 'merchants?page=' + page;
        Vue.http.get(url).then(response => {
            commit('setDatas', response.body.infor.data);
            commit('setTotal', response.body.infor.total);
            commit('setPageSize', response.body.infor.per_page);
        })
    }
}

const mutations = {
    setDatas (state, datas) {
        state.datas = datas;
    },
    setTotal (state, total) {
        state.total = total;
    },
    setPageSize (state, page_size) {
        state.page_size = page_size;
    },
    openDialog (state) {
        state.is_dialog_visible = true;
    },
    closeDialog (state) {
        state.is_dialog_visible = false;
    },
    setFormData (state, data) {
        state.form_data.id       = data.id;
        state.form_data.name     = data.name;
        state.form_data.image    = data.image;
        state.form_data.mobile   = data.mobile;
        state.form_data.province = data.province;
        state.form_data.city     = data.city;
        state.form_data.district = data.district;
        state.form_data.address  = data.address;
        state.form_data.fare     = data.fare;
    },
    clearFormData (state) {
        state.form_data.id       = 0;
        state.form_data.name     = '';
        state.form_data.image    = '';
        state.form_data.mobile   = '';
        state.form_data.province = '';
        state.form_data.city     = '';
        state.form_data.district = '';
        state.form_data.address  = '';
        state.form_data.fare     = 0;
    },
    updateImage (state, response) {
        state.form_data.image = response;
    },
}

export default {
    state,
    actions,
    mutations
}